// TEXT.CPP
//
// This file contains the code for parsing the input string,
// generating the correct phonems from the text,
// calculating the prosody of the text,
// and converting the phonemes and prosody into an Mbrola string
// which is then sent to the MBROLA module.

//#include <windows.h>
#include <string.h>
#include <stdlib.h>
#include "stdafx.h"
#include <afxcoll.h>
#include "textalk.h"
#include "textalkDoc.h"
#include "textalkView.h"
#include <stdio.h>
#include "text.h"
#include "mbrplay.h"

//prototype of the function in phoneme.cpp
void xlate_phrase(LPCTSTR text_word, CString& ret_phon); 

// CWordObj is a structure that contains all important 
// information about a word
class CWordObj : public CObject
{
private:
public:
    CString w_text;
	CString w_phon;
    char syllables;
	char phonemes;
	char phoneme[MAX_PHONEMES]; //numerical index to each phoneme
	int pitch[MAX_PHONEMES];  //pitch data for each phoneme
		
    CWordObj() {}
};

// words is an array of CWordObj pointers
// elements are created and linked to this array
// and then deleted after use
CWordObj *words[MAX_WORDS];

// word_ptr is equal to the number of words in the array
int word_ptr = 0;

//msg is a string used to send messages to the user
CString msg;

// MBrola is the string containing all phoneme and 
// pitch information and is sent as an argument
// to the MBR_Play function.
CString MBrola; 

// variables containing the current pitch, freq and speed ratios
float pitch_ratio = 1.0;
float duration_ratio = 1.0;
long voice_freq = 16000;

// when prosody_flag is zero, prosody is turned off
char prosody_flag = 1;

// stress pitch variables
int primary_stress = 25;
int secondary_stress = 15;
int n_pitch = 120;
int max_pitch = 130;
int min_pitch = 110;

// a lookup table that takes in a char value from a cuv phoneme
// string and gives an index number for that phoneme.
// The table has an offset of 38 (thus position 0 is ascii 38)
char phon_lookup[85] = {64,0,0,0,0,0,0,0,0,0,
						66,0,0,61,0,0,0,0,0,0,
						0,0,0,0,0,0,68,58,0,0,
						53,0,0,0,0,62,0,0,0,0,
						51,59,0,0,0,54,52,67,65,0,
						0,0,55,0,0,0,0,0,0,1,
						34,0,36,63,42,48,46,57,56,37,
						40,38,39,2,33,0,41,44,35,60,
						43,47,0,0,45};

// a phoneme lookup table for the ttp algorithm phonemes
// has an offset of 65
// the index is the ascii (char) value of a character, and the
// result is a char which represents the phoneme.
char p_lookup[59] = {58,0,49,53,61,0,0,46,57,0,
					0,0,0,51,71,0,0,0,54,52,
					67,0,47,0,60,55,0,0,0,0,
					0,0,0,34,0,36,0,42,48,0,
					0,50,37,40,38,39,0,33,0,41,
					44,35,0,43,47,0,56,45
};

// a lookup table that gives the average durations for each phoneme
// it is indexed with an offset of 33
int phon_dur[44] = {97,65,67,48,87,64,59,54,59,88,
					54,104,72,48,61,64,124,84,61,92,
					21,108,91,35,78,166,127,88,127,59,
					84,106,90,89,58,41,128,131,112,132,
					134,119,86,134};

// a lookup table that gives the MBrola phoneme
// it is indexed with an offset of 33 (as above), and a multiplier of 2
// (each entry is 2 bytes long)
char mbr_phon[89] = {"p b t d k m n l r f v s z h w g tSdZN T D S Z j i:A:O:u:3:I e { V Q U @ eIaIOI@UaUI@e@U@"};

//global file pointer to the dictionary file
FILE *dictfile;

/////////////////////////////////////////////////////////////////////////////
// speak is called when the play button is pressed
// First the diphone database and the dictionary file are initialised.
// Then, it picks out words (separated by whitespace) and sends them
// to the word parser which adds them to the words array.
// Once a sentence is complete, mbr_convert_list is called to 
// analyse the owrds in the array and calculate prosody. 
void speak(LPCTSTR textstr_in)
{
	CString window_str = textstr_in;
	int cursor = 0;

	word_ptr = 0;
	// set the database to en1, and show error if en1 is not registered
	if (MBR_SetDatabase("en1") > 0) {
		AfxMessageBox("Database en1 not registered.", MB_OK, 0);
		return;
	}
	// open the dictionary file
	dictfile = fopen(DICTIONARY, "rb");
	if (dictfile == NULL) {
		AfxMessageBox("Error opening dictionary", MB_OK, 0);
		return;
	}
	// parse textstr
	window_str.TrimLeft();
	window_str.TrimRight();
	while (window_str.IsEmpty() == 0) {
		cursor = window_str.FindOneOf(" \n\t");
		if (cursor >= 0) {
			if (parse_word(window_str.Left(cursor)) == SENTENCE_END) {
				// convert the readymade word list (should empty it)
				// this also does play_list if the buffer is too big
				mbr_convert_list();
			}
			window_str = window_str.Mid(cursor);
			window_str.TrimLeft();
		}
		else {
			if (window_str.IsEmpty() == 0) {
				parse_word(window_str);
				window_str.Empty();
			}
		}
	}
	// convert extra words if there are any.
	if (word_ptr > 0)
		mbr_convert_list();
	// play the MBrola output buffer if there is stuff in it
	if (MBrola.GetLength() > 0)
		play_list();
	fclose(dictfile);
}

/////////////////////////////////////////////////////////////////////////////
// Converts the text string given to a phoneme string based on the CUV2 
// dictionary.  binary search is used to locate the text string.  Because all 
// entries in the ictionary are of constant length, it is easy to find the 
// byte offset of an entry given its entry number.
// If the word is not found, a null string is returned.
int CUV2_ttp(char *text, char *phon) 
{
	unsigned long int entry; // the number of the current entry 
	
	// upper and lower are the inclusive limits of the area not searched
	// in the dictionary. They refer to entry numbers.
	unsigned long int upper, lower;
	char entry_tex[TEXTLEN + 1];  // contains the current entry's text string 
	char search_tex[TEXTLEN + 1]; // a copy of the search string 
	char compare;
	char not_found = T_FALSE;
	char pos = 0; // position within the phoneme string 
	unsigned char count;
	
	// fill text with spaces so it matches the dictionary
	for (count = 0; count < strlen(text); count++)
		search_tex[count] = text[count];
	for (count = strlen(text); count <= TEXTLEN; count ++)
		search_tex[count] = ' ';
	upper = MAX_ENTRIES - 1;
	lower = 0;
	entry = upper >> 1;	// divide by 2 to give middle entry

	// go to position in dictionary file, and compare the given text to
	// the text for that dictionary entry.
	fseek(dictfile, entry * ENTRY_SIZE, SEEK_SET);
	fread(entry_tex, TEXTLEN, 1, dictfile);
	compare = _strnicmp(search_tex, entry_tex, TEXTLEN);
	while((compare != 0) && (not_found == T_FALSE)) {
		entry_tex[TEXTLEN] = 0;
		
		// get the next entry
		if (compare < 0) {
			upper = entry;
	
			// entry is decreased by half the area not searched above 
			// it rounded up.
			entry -= (entry - lower + 1) >> 1; 
		}else {
			lower = entry;

			// entry is increased by half the area not searched below 
			// itrounded up.
			entry += (upper - entry + 1) >> 1;
		}
		
		// move to new entry and compare the text with the search text
		fseek(dictfile, entry * ENTRY_SIZE, SEEK_SET);
		fread(entry_tex, TEXTLEN, 1, dictfile);
		compare = _strnicmp(search_tex, entry_tex, TEXTLEN);

		// if at either end of the dictionary and the record is not found
		if ((compare != 0) && ((entry == upper) || (entry == lower))) 
			not_found = T_TRUE;
	}

	// get the phoneme if a text match is found, else return a null string
	if (not_found == T_FALSE) {
		fseek(dictfile, (entry * ENTRY_SIZE) + PHON_OFFS, SEEK_SET);
		fread(phon, TEXTLEN, 1, dictfile);

		// now we put the null character at the end of the phoneme string
		// i.e. when the first space character is detected.
		while(phon[pos] != ' ')
			pos ++;
		phon[pos] = 0;
		return 1;
	} 
	else {
		phon[0] = 0; // null character at the start of the phoneme string 
		return 0;
	}
}

/////////////////////////////////////////////////////////////////////////////
// dict is a funtcion that converts between the CStrings used in TexTalk, 
// and  the char*'s which are used in the dictionary lookup.
int dict(LPCTSTR in, CString& out) {
	char phon[TEXTLEN + 1];
	char tex[TEXTLEN + 1];
	strncpy(tex, in, TEXTLEN);
	if (tex[0] < 65 || tex[0] > 122 || (tex[0] > 90 && tex[0] < 97)) {
		// first character is bad.
		return 0;
	}
	if (CUV2_ttp(tex, (char *)phon) == 0) {
 		return 0;
	}
	else {
		out = phon;
		return 1;
	}
}

/////////////////////////////////////////////////////////////////////////////
// add_word takes the text and CUV2 phonetic representation, creates 
// a new CWordObj object, links the words array to it, and fills in
// all the information about the word including:
// spelling, CUV2 phoneme representation, number of phonemes,
// the index value of each phoneme, and any stress information about
// each phoneme. the bulk of the function deals with converting the 
// one or two letter CUV phonemes into the index of phonemes used in TexTalk.
void add_word(LPCTSTR w_in, LPCTSTR p_in) 
{
	CString phon;
	char p, p2;
	int index = 0;
	int length;
	int phonemes = 0;
	char stress_flag = 0;
	// This version of Mbrola's diphone database cannot say the letters
	// "TCH". special_word indicates if the letters are present in the 
	// word. 
	int special_word = 0; 

	phon = p_in;
	length = phon.GetLength();
	words[word_ptr] = new CWordObj;
	words[word_ptr]->w_text = w_in;
	words[word_ptr]->w_phon = p_in;
	if (words[word_ptr]->w_text.Find("tch") >= 0 || 
			words[word_ptr]->w_text.Find("TCH") >= 0)
		special_word = 1;
	if (p_in[0] == '_') {
		words[word_ptr]->phonemes = phonemes;
		word_ptr ++;
		return;
	}
	// convert the dict phoneme string to indexes in the phoneme array
	while (index < length) {
		// set the stress level of the next phoneme
		if (phon[index] == 39) {  
			words[word_ptr]->pitch[phonemes] = primary_stress;
			stress_flag = 1;
		}
		else if (phon[index] == 44) {
			words[word_ptr]->pitch[phonemes] = secondary_stress;
			stress_flag = 1;
		}
		else {
			if (stress_flag == 1)
				stress_flag = 0;
			else
				words[word_ptr]->pitch[phonemes] = NO_STRESS;
		}
		// calculate the next phoneme
		if (phon[index] > 37) {
			p = phon_lookup[phon[index] - 38];
			if (p == 1 || p == 2 || p == 68 || p == 35 || p == 36 ||
				p == 63 || p == 62 || p == 67) {
				// the character may be part of a 2 letter phoneme
				if (length > index + 1) {
					p2 = phon[index + 1];
					if (p == 1) {
						if (p2 == 'I')
							words[word_ptr]->phoneme[phonemes] = 70;
						else if (p2 == 'U')
							words[word_ptr]->phoneme[phonemes] = 73;
						else 
							words[word_ptr]->phoneme[phonemes] = p;
					}
					else if (p == 2) {
						if (p2 == 'I')
							words[word_ptr]->phoneme[phonemes] = 71;
						else 
							words[word_ptr]->phoneme[phonemes] = p;
					}
					else if (p == 68) {
						if (p2 == 'U')
							words[word_ptr]->phoneme[phonemes] = 72;
						else 
							words[word_ptr]->phoneme[phonemes] = p;
					}
					else if (p == 35) {
						if (p2 == 'S') {
							// exception
							if (special_word == 1 && phonemes > 0 && 
								words[word_ptr]->phoneme[phonemes-1] != 35) {
									words[word_ptr]->phoneme[phonemes] = 35;
									phonemes ++;
									words[word_ptr]->phoneme[phonemes] = 49;
							}
							else {
								words[word_ptr]->phoneme[phonemes] = 49;
							}
						}
						else {
							words[word_ptr]->phoneme[phonemes] = p;
						}
					}
					else if (p == 36) {
						if (p2 == 'Z')
							words[word_ptr]->phoneme[phonemes] = 50;
						else 
							words[word_ptr]->phoneme[phonemes] = p;
					}
					else if (p == 63) {
						if (p2 == 'I')
							words[word_ptr]->phoneme[phonemes] = 69;
						else if (p2 == '@')
							words[word_ptr]->phoneme[phonemes] = 75;
						else
							words[word_ptr]->phoneme[phonemes] = p;
					}
					else if (p == 62) {
						if (p2 == '@')
							words[word_ptr]->phoneme[phonemes] = 74;
						else 
							words[word_ptr]->phoneme[phonemes] = p;
					}
					else if (p == 67) {
						if (p2 == '@')
							words[word_ptr]->phoneme[phonemes] = 76;
						else 
							words[word_ptr]->phoneme[phonemes] = p;
					}
					if (words[word_ptr]->phoneme[phonemes] != p)
						index ++; // it was a 2 letter phoneme
				}
				else {
					words[word_ptr]->phoneme[phonemes] = p;
				}
			}
			else {
				words[word_ptr]->phoneme[phonemes] = p;
			}
			if (words[word_ptr]->phoneme[phonemes] > 32) {
				//phoneme is correct, increment the index
				phonemes ++;
			}
		}
		index ++;
	}
	words[word_ptr]->phonemes = phonemes;
	word_ptr ++;
}

/////////////////////////////////////////////////////////////////////////////
// parse_word is a recursive function which takes a series of non-whitespace
// characters as input. It breaks the string into parts containing
// numbers, letters, and symbols.
// Symbols that are recognised are parsed as their word equivalents
// Numbers are sent to say_number() for conversion into words.
// Letters are sent to the dictionary, and if not found there, 
// to the xlate_phrase() function which uses letter ot sound rules.
int parse_word(LPCTSTR word_in)
{
	CString phoneme;
	CString word = word_in;
	int ptr;

	// get rid of trailing newline characters
	ptr = word.GetLength() - 1;
 	if (word[ptr] >= 0 && word[ptr] < 32) {
		word = word.Left(ptr);
	}
	// parse single character strings
	if (word.GetLength() == 1) {
		if (word.FindOneOf(".?!:;,") >= 0) {
			// add the punctuation mark to the word list,
			// and add the appropriate delay too.
			if (word[0] == '.' || word[0] == ':')
				add_word(word, "_ 600"); //delay for full stop or colon
			else if (word[0] == '?' || word[0] == '!')
				add_word(word, "_ 600"); // ! or ? delay
			else if (word[0] == ',' || word[0] == ';')
				add_word(word, "_ 300"); // semi colon or comma delay
			if (word[0] == '.' || word[0] == '!' || word[0] == '?')
				return SENTENCE_END;
			else
				return WORD_FOUND;
		}
		// parse known symbols
		if (word[0] == '$')
			return parse_word("dollars");
		if (word[0] == '+')
			return parse_word("plus");
		if (word[0] == '/')
			return parse_word("slash");
		if (word[0] == '=')
			return parse_word("equals");
		if (word[0] == '-')
			return parse_word("minus");
		if (word[0] == '&')
			return parse_word("and");
		if (word[0] == '*')
			return parse_word("asterisk");
		if (word[0] == '#')
			return parse_word("hash");
		if (word[0] == '%')
			return parse_word("percent");
		// not a specific character, then search dict
		//if (word[0] > (if in range then search dict)
		if (dict(word, phoneme) == 0) {
			if (word.FindOneOf("0123456789") == 0) 
				return parse_word(Cardinals[atoi(word)]);
			return UNKNOWN_WORD;
		}
		else {
			// add phoneme to word list
			add_word(word, phoneme);
			return WORD_FOUND;
		}
	}
	// multi character word
	if (dict(word, phoneme) != 0) {
		// add phoneme to word list
		add_word(word, phoneme);
		return WORD_FOUND;
	}
	// get rid of hyphens
	ptr = word.Find('-');
	if (ptr != -1) {
		word = word.Left(ptr) + word.Mid(ptr+1);
	}
	// search for a number
	ptr = word.FindOneOf("0123456789");
	if (ptr == 0) {
		extract_number(word);
		if (word.GetLength() > 0) 
			return parse_word(word);
		else 
			return UNKNOWN_WORD;
	}
	// search for a number or symbol
	ptr = word.FindOneOf(".,;:?!%&#/-+*=$0123456789\"\'");
	if (ptr == 0) {
		// process the first char as a word, then process the rest
		if (word[0] == '$') {
			// process a dollar value.
		}
		if (word[0] == '\"' || word[0] == '\'') {
			// ignore the char, and process the rest.
			return parse_word(word.Mid(1));
		}
		// process the first character, then the rest
		if (parse_word(word.Left(1)) == SENTENCE_END) {
			parse_word(word.Mid(1));
			return SENTENCE_END;
		}
		return parse_word(word.Mid(1));
	}
	else if (ptr > 0) {
		// process the part up to the char, then process the rest
		parse_word(word.SpanExcluding(".,;:?!%&#/-+*=$0123456789\"\'"));
		return parse_word(word.Mid(ptr));
	}
	else {
		// there is no wierd character in the word
		// construct the pronunciation manually
		if (word[0] < 65 || word[0] > 122 || 
				(word[0] > 90 && word[0] < 97)) {
			// there first character is bad
			//parse the rest of the word
			if (word.GetLength() > 0)
				return parse_word(word.Mid(1));
		}
		// send the word to the translation module
		xlate_phrase(word, phoneme);
		p_add_word(word, phoneme);
	}
	return UNKNOWN_WORD;
}


/////////////////////////////////////////////////////////////////////////////
// say number takes an integer and converts it to words.
// whenever a new word part of the number is determined, the word
// is sent to parse_word() so it can be added to the word list.
void say_number(long int value)
{
	if (value < 0) {
		parse_word("minus");
		value = (-value);
		if (value < 0)	// Overflow!  -32768 
			{
			parse_word("infinity");
			return;
			}
	}
	if (value >= 1000000000L) {		// Billions 
		say_number(value/1000000000L);
		parse_word("billion");
		value = value % 1000000000;
		if (value == 0)
			return;		// Even billion
		if (value < 100)	// as in THREE BILLION AND FIVE
			parse_word("and");
	}
	if (value >= 1000000L) {		// Millions
		say_number(value/1000000L);
		parse_word("million");
		value = value % 1000000L;
		if (value == 0)
			return;		// Even million
		if (value < 100)	// as in THREE MILLION AND FIVE
			parse_word("and");
	}
	// was :1100 to 1999 is eleven-hunderd to ninteen-hunderd
	// was :if ((value >= 1000L && value <= 1099L) || value >= 2000L)
	if (value >= 1000L) {		// Thousands
		say_number(value/1000L);
		parse_word("thousand");
		value = value % 1000L;
		if (value == 0)
			return;			// Even thousand
		if (value < 100)	// as in THREE THOUSAND AND FIVE
			parse_word("and");
	}
	if (value >= 100L) {		// Hundreds
		parse_word(Cardinals[value/100]);
		parse_word("hundred");
		value = value % 100;
		if (value == 0)
			return;		// Even hundred
		parse_word("and");
	}
	if (value >= 20) {
		parse_word(Twenties[(value-20)/ 10]);
		value = value % 10;
		if (value == 0)
			return;		// Even ten
	}
	parse_word(Cardinals[value]);
	return;
} 

/////////////////////////////////////////////////////////////////////////////
// extract_number takes the first numerical string out of the word string
// and sent the number string to say_number()
void extract_number(CString& word) {
	// TO DO: process a number including decimal point 	
	CString number;
	int ptr = 0;
	while (word.FindOneOf("0123456789") >= 0) {
		number += word.Left(1);
		word = word.Mid(1);
	}
	say_number(atol(number));
}

/////////////////////////////////////////////////////////////////////////////
// p_add_word is the equivalent of add_word, but works on the phoneme
// string returned by xlate_phrase().
void p_add_word(LPCTSTR w_in, LPCTSTR p_in)
{
	CString phon;
	char p, p2;
	int index = 0;
	int length;
	int phonemes = 0;
	int special_word = 0; // indicates an exception to the rule

	phon = p_in;
	length = phon.GetLength();
	words[word_ptr] = new CWordObj;
	words[word_ptr]->w_text = w_in;
	words[word_ptr]->w_phon = p_in;
	// now convert the dict phoneme string to numbers in the phoneme array
	while (index < length && phonemes < (MAX_PHONEMES - 1)) {
		if (phon[index] > 64) {
			p = p_lookup[phon[index] - 65];
			if (phon[index] < 97) { 
				// the character is a capital 
				// and is the first of a 2 char phoneme
				if (length > index + 1) {
					p2 = phon[index + 1];
					if (p == 57) {		// if I*
						if (p2 == 'Y')
							words[word_ptr]->phoneme[phonemes] = p;
						else if (p2 == 'H')
							words[word_ptr]->phoneme[phonemes] = 62;
					}
					if (p == 58) {		// If A*
						if (p2 == 'A')
							words[word_ptr]->phoneme[phonemes] = p;
						else if (p2 == 'O')
							words[word_ptr]->phoneme[phonemes] = 59;
						else if (p2 == 'H')
							words[word_ptr]->phoneme[phonemes] = 65;
						else if (p2 == 'X')
							words[word_ptr]->phoneme[phonemes] = 68;
						else if (p2 == 'Y')
							words[word_ptr]->phoneme[phonemes] = 70;
						else if (p2 == 'W')
							words[word_ptr]->phoneme[phonemes] = 73;
						else if (p2 == 'E')
							words[word_ptr]->phoneme[phonemes] = 64;
					}
					if (p == 61) {		// if E*
						if (p2 == 'R')
							words[word_ptr]->phoneme[phonemes] = p;
						else if (p2 == 'H')
							words[word_ptr]->phoneme[phonemes] = 63;
						else if (p2 == 'Y')
							words[word_ptr]->phoneme[phonemes] = 69;
					}
					if (p == 67) {		// if U*
						if (p2 == 'H')
							words[word_ptr]->phoneme[phonemes] = p;
						else if (p2 == 'W')
							words[word_ptr]->phoneme[phonemes] = 76;
					}
					if (p == 71) {		// if O*
						if (p2 == 'Y')
							words[word_ptr]->phoneme[phonemes] = p;
						else if (p2 == 'W')
							words[word_ptr]->phoneme[phonemes] = 72;
					}
					// if p was 46,47,49,51 to 55 or 60, then it 
					// doesn't matter what the second letter is.
					else if (p == 46 || p == 47 || p == 49 || 
						(p >= 51 && p <= 55) || p == 60)  
						words[word_ptr]->phoneme[phonemes] = p;
					index ++; // it was a 2 letter phoneme
				}
			}
			else {
				words[word_ptr]->phoneme[phonemes] = p;
			}
			if (words[word_ptr]->phoneme[phonemes] > 32) {
				//phoneme is correct
				words[word_ptr]->pitch[phonemes] = NO_STRESS;
				phonemes ++;
			}
		}
		index ++;
	}
	words[word_ptr]->phonemes = phonemes;
	word_ptr ++;
}


/////////////////////////////////////////////////////////////////////////////
// mbr_convert_list works on the list of words and word attributes stored
// in the words array. word_ptr gives the current number of swords in the
// list. the function first calculates the overall pitch contour of the
// sentence, depending of the ending punctuation, and the start word.
// Then, each word is converted into an Mbrola string including pitch
// information for each phoneme. this is then added to the string: MBrola
// If the MBrola string is too long, it is sent to MBR_Play() to synthesise.
void mbr_convert_list(void) {
	char duration[10];
	char s_pitch[10];
	int pitch;
	int dur;
	int dummy_ptr;
	int count, i;
	int total_phon = 0; // number of phonemes in sentence
	int num_phon = 0; // the current phoneme number
	char falling; // 2 = no pitch contour. 0 = rising. 1 = falling.
	CString word_text;

	falling = 2;
	if (MBrola.GetLength() == 0)
		MBrola = "_ 75 \n"; // starting phoneme
	word_text = words[0]->w_text;
	if (words[word_ptr-1]->w_text[0] == '!') {
		falling = 0;
	}
	if (words[word_ptr-1]->w_text[0] == '.') {
		falling = 1;
	}
	if (words[word_ptr-1]->w_text[0] == '?') {
		if (word_text.CompareNoCase("why") &&
				word_text.CompareNoCase("where") &&
				word_text.CompareNoCase("what") &&
				word_text.CompareNoCase("how") &&
				word_text.CompareNoCase("who") &&
				word_text.CompareNoCase("when")) {
			falling = 0;
		}
		else {
			falling = 1;
		}
	}
	// if prosody turned off, then set contour to flat.
	if (prosody_flag == 0)
		falling = 2;
	// count the number of phonemes in the sentence
	for(dummy_ptr = 0;dummy_ptr < word_ptr;dummy_ptr ++) {
		total_phon += words[dummy_ptr]->phonemes;
	}

	for(dummy_ptr = 0;dummy_ptr < word_ptr;dummy_ptr ++) {
		if (words[dummy_ptr]->w_phon[0] == '_') {
			// straight map to mbrola
			MBrola += words[dummy_ptr]->w_phon;
			MBrola += " \n";
		}
		else {
			for (count = 0; count < words[dummy_ptr]->phonemes; count ++) {
				num_phon ++;
				i = words[dummy_ptr]->phoneme[count];
				MBrola += mbr_phon[(i - 33) * 2];
				MBrola += mbr_phon[(i - 33) * 2 + 1];
				MBrola += " ";
				dur = phon_dur[i-33];
				if (count+1 == words[dummy_ptr]->phonemes) 
					dur += 60;
				MBrola += _itoa( dur, duration, 10);
				MBrola += " 50 "; //pitch data is at the 50% position
				if (falling == 2) {
					if (prosody_flag == 0)
						pitch = n_pitch;
					else 
						pitch = n_pitch + (words[dummy_ptr]->pitch[count]);
				}
				else if (falling == 1) {
					pitch = max_pitch + words[dummy_ptr]->pitch[count] -
					((max_pitch - min_pitch) * num_phon / total_phon);
				}
				else {
					pitch = min_pitch + words[dummy_ptr]->pitch[count] +
					((max_pitch - min_pitch) * num_phon / total_phon);
				}
				MBrola += _itoa(pitch, s_pitch, 10);
				MBrola += " \n";
			}
		}
	}

	// clear up the allocated blocks
	for (word_ptr --; word_ptr >= 0; word_ptr--) 
		delete words[word_ptr];
	word_ptr = 0;
	if (MBrola.GetLength() > 500) 
		play_list(); // play the buffer
}

///////////////////////////////////////////////////////////////////////
// play_list waits until MBrola has stopped synthesising, and then
// sends the MBrola string to the synthesiser before emtying it
// and returning.
void play_list(void) 
{
	MBrola += "_ 100 \n# \n"; // end phoneme flushes buffer
	// wait until previous sentence is finished
	MBR_WaitForEnd();
	if (MBR_Play(MBrola, MBROUT_SOUNDBOARD, NULL, NULL) > 0)
		AfxMessageBox("Error speaking", MB_OK, 0);
	MBrola.Empty(); //empty the buffer
}

