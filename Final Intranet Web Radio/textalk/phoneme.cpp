// PHONEME.CPP
//
// this file contains the functions used to convert a word in 
// text form into a string of phonemes
//
//	English to Phoneme translation.
//
//	Rules are made up of four parts:
//	
//		The left context.
//		The text to match.
//		The right context.
//		The phonemes to substitute for the matched text.
//
//	Procedure:
//
//		Seperate each block of letters (apostrophes included) 
//		and add a space on each side.  For each unmatched 
//		letter in the word, look through the rules where the 
//		text to match starts with the letter in the word.  If 
//		the text to match is found and the right and left 
//		context patterns also match, output the phonemes for 
//		that rule and skip to the next unmatched letter.
//
//
//	Special Context Symbols:
//
//		#	One or more vowels
//		:	Zero or more consonants
//		^	One consonant.
//		.	One of B, D, V, G, J, L, M, N, R, W or Z (voiced 
//			consonants)
//		%	One of ER, E, ES, ED, ING, ELY (a suffix)
//			(Right context only)
//		+	One of E, I or Y (a "front" vowel)

//#include <windows.h>
#include <string.h>
#include <stdlib.h>
#include "stdafx.h"
#include <stdio.h>
#include <ctype.h>
#include "phoneme.h"
#include "textalk.h"

static int Char, Char1, Char2, Char3;
CString the_word;
CString the_phon;
CString p_msg;

typedef char *PRule[4];	// A rule is four character pointers

extern PRule *Rules[];	// An array of pointers to rules

/////////////////////////////////////////////////////////////////////////////
// makeupper turns lowercase letters into uppercase letters
int makeupper(int character)
{
	if (islower(character))
		return toupper(character);
	else
		return character;
}

/////////////////////////////////////////////////////////////////////////////
// returns a boolean value, TRUE for a vowel, and FALSE for a consonant.
int isvowel(char chr)
{
	return (chr == 'A' || chr == 'E' || chr == 'I' || 
		chr == 'O' || chr == 'U');
}

/////////////////////////////////////////////////////////////////////////////
// returns a boolean value, FALSE for a vowel, and TRUE for a consonant.
int isconsonant(char chr)
{
	return (isupper(chr) && !isvowel(chr));
}

/////////////////////////////////////////////////////////////////////////////
// xlate_word is called from the hane_letter function
// It turns turns the parsed word into phonemes by finding rules
// that match the letter patterns of the word.
void xlate_word(char *word)
{
	int index;	// Current position in word
	int type;	// First letter of match part 

	index = 1;	// Skip the initial blank
	do {
		if (isupper(word[index]))
			type = word[index] - 'A' + 1;
		else
			type = 0;
		index = find_rule(word, index, Rules[type]);
	} while (word[index] != '\0');
}

/////////////////////////////////////////////////////////////////////////////
// find_rule tries to find a rule that matches the current set of letters
// that are being looked at in the word.
int find_rule(char *word, int index, PRule *rules)
{
	PRule *rule;
	char *left, *match, *right, *output;
	int remainder;

	// Search for the rule
	for (;;) {	
		rule = rules++;
		match = (*rule)[1];

		if (match == 0)	{ // bad symbol! 
			return index+1;	// Skip it! 
		}
		for (remainder = index; *match != '\0'; match++, remainder++) {
			if (*match != word[remainder])
				break;
		}
		if (*match != '\0')	// found missmatch
			continue;
		left = (*rule)[0];
		right = (*rule)[2];
		if (!leftmatch(left, &word[index-1]))
			continue;
		if (!rightmatch(right, &word[remainder]))
			continue;
		output = (*rule)[3];
		outstring(output);
		return remainder;
	}
}


/////////////////////////////////////////////////////////////////////////////
// leftmatch finds patterns which match the left end of the word.
char leftmatch(char *pattern, char *context)
{
	char *pat;
	char *text;
	int count;

	if (*pattern == '\0') {	// null string matches any context
		return P_TRUE;
	}

	// point to last character in pattern string
	count = strlen(pattern);
	pat = pattern + (count - 1);

	text = context;

	for (; count > 0; pat--, count--) {
		// First check for simple text or space
		if (isalpha(*pat) || *pat == '\'' || *pat == ' ')
			if (*pat != *text)
				return P_FALSE;
			else {
				text--;
				continue;
			}
		switch (*pat) {
		case '#':	// One or more vowels
			if (!isvowel(*text))
				return P_FALSE;

			text--;

			while (isvowel(*text))
				text--;
			break;

		case ':':	// Zero or more consonants
			while (isconsonant(*text))
				text--;
			break;

		case '^':	// One consonant
			if (!isconsonant(*text))
				return P_FALSE;
			text--;
			break;

		case '.':	// B, D, V, G, J, L, M, N, R, W, Z
			if (*text != 'B' && *text != 'D' && *text != 'V'
			   && *text != 'G' && *text != 'J' && *text != 'L'
			   && *text != 'M' && *text != 'N' && *text != 'R'
			   && *text != 'W' && *text != 'Z')
				return P_FALSE;
			text--;
			break;

		case '+':	// E, I or Y (front vowel)
			if (*text != 'E' && *text != 'I' && *text != 'Y')
				return P_FALSE;
			text--;
			break;

		case '%':
		default:
			fprintf(stderr, "Bad char in left rule: '%c'\n", *pat);
			return P_FALSE;
		}
	}
	return P_TRUE;
}

/////////////////////////////////////////////////////////////////////////////
// rightmatch finds patterns which match the right end of the word.
char rightmatch(char *pattern, char *context)
{
	char *pat;
	char *text;

	if (*pattern == '\0')	// null string matches any context
		return P_TRUE;
	pat = pattern;
	text = context;
	for (pat = pattern; *pat != '\0'; pat++) {
		// First check for simple text or space
		if (isalpha(*pat) || *pat == '\'' || *pat == ' ')
			if (*pat != *text)
				return P_FALSE;
			else {
				text++;
				continue;
			}
		switch (*pat) {
		case '#':	// One or more vowels
			if (!isvowel(*text))
				return P_FALSE;
			text++;
			while (isvowel(*text))
				text++;
			break;
		case ':':	// Zero or more consonants
			while (isconsonant(*text))
				text++;
			break;
		case '^':	// One consonant
			if (!isconsonant(*text))
				return P_FALSE;
			text++;
			break;
		case '.':	// B, D, V, G, J, L, M, N, R, W, Z
			if (*text != 'B' && *text != 'D' && *text != 'V'
			   && *text != 'G' && *text != 'J' && *text != 'L'
			   && *text != 'M' && *text != 'N' && *text != 'R'
			   && *text != 'W' && *text != 'Z')
				return P_FALSE;
			text++;
			break;
		case '+':	// E, I or Y (front vowel)
			if (*text != 'E' && *text != 'I' && *text != 'Y')
				return P_FALSE;
			text++;
			break;
		case '%':	// ER, E, ES, ED, ING, ELY (a suffix)
			if (*text == 'E') {
				text++;
				if (*text == 'L') {
					text++;
					if (*text == 'Y') {
						text++;
						break;
					}
					else {
						text--; // Don't gobble L
						break;
					}
				}
				else if (*text == 'R' || *text == 'S' 
				   || *text == 'D')
					text++;
				break;
			}
			else if (*text == 'I') {
				text++;
				if (*text == 'N') {
					text++;
					if (*text == 'G') {
						text++;
						break;
					}
				}
				return P_FALSE;
			}
			else
				return P_FALSE;
		default:
			fprintf(stderr, "Bad char in right rule:'%c'\n", *pat);
			return P_FALSE;
		}
	}
	return P_TRUE;
}

/////////////////////////////////////////////////////////////////////////////
// have_letter processes the word, assuming the word contains letters
// Then it sends it to xlate_word.
void have_letter(void)
{
	char buff[MAX_LENGTH];
	int count;

	count = 0;
	buff[count++] = ' ';	// Required initial blank
	buff[count++] = makeupper(Char);
	for (new_char() ; isalpha(Char) || Char == '\'' ; new_char()) {
		buff[count++] = makeupper(Char);
		if (count > MAX_LENGTH-2) {
			buff[count++] = ' ';
			buff[count++] = '\0';
			xlate_word(buff);
			count = 1;
		}
	}
	buff[count++] = ' ';	// Required terminating blank
	buff[count++] = '\0';
	xlate_word(buff);
	if (Char == '-' && isalpha(Char1))
		new_char();	// Skip hyphens
}

/////////////////////////////////////////////////////////////////////////////
// new_char gets the next char of the word and pumps the last chars 
// down through char1, char2, and char3
void new_char(void)
{
	// If the cache is full of newline, time to prime the look-ahead
	// again.  If an EOW is found, fill the remainder of the queue with
	// EOW's.
	if (Char == '\n'  && Char1 == '\n' && Char2 == '\n' && Char3 == '\n') {	
		// prime the pump again
		if (the_word.GetLength() == 0) {
			Char = EOW;
			Char1 = EOW;
			Char2 = EOW;
			Char3 = EOW;
			return;
		}
		Char = the_word[0];
		the_word = the_word.Mid(1);
		if (the_word.GetLength() == 0) {
			Char1 = EOW;
			Char2 = EOW;
			Char3 = EOW;
			return;
		}
		if (Char == '\n')
			return;
		Char1 = the_word[0];
		the_word = the_word.Mid(1);
		if (the_word.GetLength() == 0) {
			Char2 = EOW;
			Char3 = EOW;
			return;
		}
		if (Char1 == '\n')
			return;
		Char2 = the_word[0];
		the_word = the_word.Mid(1);
		if (the_word.GetLength() == 0) {
			Char3 = EOW;
			return;
		}
		if (Char2 == '\n')
			return;
		Char3 = the_word[0];
		the_word = the_word.Mid(1);
	}
	else {
		// Buffer not full of newline, shuffle the characters and
		// either get a new one or propagate a newline or EOW.
		Char = Char1;
		Char1 = Char2;
		Char2 = Char3;
		if (the_word.GetLength() > 0) {
			Char3 = the_word[0];
			the_word = the_word.Mid(1);
		}
		else
			Char3 = EOW;
	}
	return;
}

/////////////////////////////////////////////////////////////////////////////
// xlate_phrase is the function called from TEXT.CPP to convert the word
// into phoneme form.
void xlate_phrase(LPCTSTR text_word, CString& ret_phon)
{
	// Prime the queue
	Char = '\n';
	Char1 = '\n';
	Char2 = '\n';
	Char3 = '\n';
	the_phon.Empty();
	the_word = text_word;
	new_char();	// Fill Char, Char1, Char2 and Char3
	have_letter();
	ret_phon = the_phon;
}

/////////////////////////////////////////////////////////////////////////////
// this function is called when another phoneme is added to the phoneme
// representation of the word.
void outstring(char *op) 
{
	the_phon += op;
}

