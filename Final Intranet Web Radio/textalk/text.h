// TEXT.H
//
// header file for TEXT.CPP. It contains the defines and prototypes

#include <windows.h>
#define CONVERT_LIMIT 2000	// maximum no. of chars in converted sentence 
#define TEXT_LIMIT 1000	// maximum no. of chars in text sentence
#define DICTIONARY "text710.dat"
/*
 * The number of entries in CUV2 is given as 70646 in the documentation.
 * They are numbered 0 to 70645.
 * The entry size is 129 bytes (including the line feed character).
 */
#define MAX_ENTRIES 70646
#define ENTRY_SIZE 129
#define TEXTLEN 23	// maximum length of text and phoneme strings 
#define PHON_OFFS 23 // byte offset for position of phoneme string in entry 
#define T_TRUE 0
#define T_FALSE -1

#define MAX_WORDS 50
#define MAX_PHONEMES 50

#define NO_STRESS 0

// parse_word return value definitions
#define WORD_FOUND 0
#define SENTENCE_END 1
#define UNKNOWN_WORD 2

void speak(LPCTSTR textstr);
void play_list(void);
void mbr_convert_list(void);
int CUV2_ttp(char *text, char *phon);
int parse_word(LPCTSTR word_in);
void add_word(LPCTSTR w_in, LPCTSTR p_in);
int dict(LPCTSTR in, CString& out);
void show_list(void);
void say_number(long int value);
void extract_number(CString& word);
void p_add_word(LPCTSTR w_in, LPCTSTR p_in);


static char *Cardinals[] = 
{
	"zero","one","two",	"three","four",	"five",	"six","seven",
	"eight","nine","ten","eleven","twelve","thirteen","fourteen",
	"fifteen","sixteen","seventeen","eighteen","nineteen"
};

static char *Twenties[] = 
{
	"twenty","thirty","forty","fifty","sixty","seventy",
	"eighty","ninety"
};

