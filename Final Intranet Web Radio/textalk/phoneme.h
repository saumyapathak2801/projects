// PHONEME.H
//
// This is a header file which contains prototypes for functions
// used in PHONEME.CPP. It also includes the letter to sound rules
// in ENGLISH.H

#include "english.h"

#define MAX_LENGTH 128 //max length of words to be converted
#define P_FALSE (0)
#define P_TRUE (!0)
#define EOW '\0' //end of word

int makeupper(int character);
int isvowel(char chr);
int isconsonant(char chr);
void xlate_word(char *word);
void xlate_phrase(LPCTSTR text_word, CString& ret_phon);
int find_rule(char *word, int index, PRule *rules);
char leftmatch(char *pattern, char *context);
char rightmatch(char *pattern, char *context);
void have_letter(void);
void new_char(void);
void outstring(char *op);

