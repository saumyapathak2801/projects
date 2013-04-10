// MBRPLAY.H
//
// This file contains the prototypes and defines for MBRPLAY.LIB

/*
 * FPMs-TCTS SOFTWARE LIBRARY
 *
 * File :    folderdialog.cpp
 * Purpose : MbrPlay functions & constants defines
 * Author  : Alain Ruelle
 * Email   : ruelle@tcts.fpms.ac.be
 *
 * Copyright (c) 1997-1998 Faculte Polytechnique de Mons (TCTS lab)
 * All rights reserved.
 *
 * Statically imported functions (through a .lib file)
 *
 */

#ifndef __MBRPLAY_H__
#define __MBRPLAY_H__

// MBR_Play & MBR_PlayToFile Flags
#define MBR_MSGINIT				1
#define MBR_MSGREAD				2
#define MBR_MSGWAIT				4
#define MBR_MSGWRITE			8
#define MBR_MSGEND				16
#define MBR_MSGALL				31
#define MBR_BYFILE				32
#define MBR_WAIT				64
#define MBR_CALLBACK			128
#define MBR_QUEUED				256
#define MBR_ASPHS				512

// MBR_SetOutputMode & MBR_GetOutputMode flags
#define MBROUT_SOUNDBOARD		0
#define MBROUT_RAW				1024
#define MBROUT_WAVE				2048
#define MBROUT_AU				4096
#define MBROUT_AIFF				8192

#define MBROUT_ALAW				16384
#define MBROUT_MULAW			32768

// Mbrola Errors
#define MBRERR_NOREGISTRY		-13		// Registry keys error
#define MBRERR_NOMBROLADLL		-12		// Mbrola DLL not found
#define MBRERR_DBINIT			-11		// No database loaded
#define MBRERR_WARNING			-10		
// Information errors
#define MBRERR_CANTOPENWAVEOUT	-9		// Can't open the wavout device
#define MBRERR_CANTOPENFILEOUT	-8
#define MBRERR_CANTOPENFILE		-7
#define MBRERR_ERRORSPEAKING	-6		// Error while Speaking
#define MBRERR_DBNOTDATABASE	-5		// Not a valid database
#define MBRERR_DBREGNOTFOUND	-4		// Database ID not found in registry
#define MBRERR_ISPLAYING		-3		// Error function used but synthe still playing
#define MBRERR_CANCELLEDBYUSER	-2
#define MBRERR_NORESOURCE		-1		// Not enough resources to play
#define MBRERR_NOERROR			0

// Mbrola Windows Messages (used for notification)
#define WM_MBR_INIT				(WM_USER+0x1BFF)
#define WM_MBR_READ				(WM_USER+0x1C00)
#define WM_MBR_WAIT				(WM_USER+0x1C01)
#define WM_MBR_WRITE			(WM_USER+0x1C02)
#define WM_MBR_END				(WM_USER+0x1C03)

// Callback Function type
typedef int (*LPPLAYCALLBACKPROC)(UINT msg, WPARAM wParam, LPARAM lParam);
typedef BOOL (*LPENUMDATABASECALLBACK)(LPCTSTR lpszDatabase, DWORD dwUserData);

extern "C"
{
LONG __declspec(dllimport) WINAPI MBR_Play(LPCTSTR lpszText,DWORD dwFlags,LPCTSTR lpszOutFile,DWORD dwCallback);
LONG __declspec(dllimport)WINAPI MBR_Stop();
LONG __declspec(dllimport) WINAPI MBR_WaitForEnd();
LONG __declspec(dllimport) WINAPI MBR_SetPitchRatio(float fPitch);
LONG __declspec(dllimport) WINAPI MBR_SetDurationRatio(float fDuration);
LONG __declspec(dllimport) WINAPI MBR_SetVoiceFreq(LONG lFreq);
float __declspec(dllimport) WINAPI MBR_GetPitchRatio();
float __declspec(dllimport) WINAPI MBR_GetDurationRatio();
LONG __declspec(dllimport) WINAPI MBR_GetVoiceFreq();
LONG __declspec(dllimport) WINAPI MBR_SetDatabase(LPCTSTR lpszID);
LONG __declspec(dllimport) WINAPI MBR_GetDatabase(LPTSTR lpID, DWORD dwSize);
BOOL __declspec(dllimport) WINAPI MBR_IsPlaying();
LONG __declspec(dllimport) WINAPI MBR_LastError(LPTSTR lpszError,DWORD dwSize);

// Syntheszier General informations
void __declspec(dllimport) WINAPI MBR_GetVersion(LPTSTR lpVersion, DWORD dwSize);

// Current Database Info
LONG __declspec(dllimport) WINAPI MBR_GetDefaultFreq();
LONG __declspec(dllimport) WINAPI MBR_GetDatabaseInfo(DWORD idx, LPTSTR lpMsg, DWORD dwSize);
LONG __declspec(dllimport) WINAPI MBR_GetDatabaseAllInfo(LPTSTR lpMsg, DWORD dwSize);

// Registry Related Functions
LONG __declspec(dllimport) WINAPI MBR_RegEnumDatabase(LPTSTR lpszData,DWORD dwSize);
LONG __declspec(dllimport) WINAPI MBR_RegEnumDatabaseCallback(LPENUMDATABASECALLBACK lpedCallback,DWORD dwUserData);
LONG __declspec(dllimport) WINAPI MBR_RegGetDatabaseLabel(LPCTSTR lpszID, LPTSTR lpLabel, DWORD dwSize);
LONG __declspec(dllimport) WINAPI MBR_RegGetDatabasePath(LPCTSTR lpszID, LPTSTR lpPath, DWORD dwSize);
LONG __declspec(dllimport) WINAPI MBR_RegGetDatabaseCount();
LONG __declspec(dllimport) WINAPI MBR_RegGetDefaultDatabase(LPTSTR lpID, DWORD dwSize);
LONG __declspec(dllimport) WINAPI MBR_RegSetDefaultDatabase(LPCTSTR lpszID);
BOOL __declspec(dllimport) WINAPI MBR_RegisterDatabase(LPCTSTR dbId,LPCTSTR dbPath,LPCTSTR dbLabel,BOOL isDef,LPTSTR lpBuffer,DWORD dwSize);
BOOL __declspec(dllimport) WINAPI MBR_UnregisterDatabase(LPCTSTR dbId);
BOOL __declspec(dllimport) WINAPI MBR_UnregisterAll();
BOOL __declspec(dllimport) WINAPI MBR_DatabaseExist(LPCTSTR lpszID);

// Registry Releated Functions, accessed by index
BOOL __declspec(dllimport) WINAPI MBR_RegIdxGetDatabaseId(LONG nIdx, LPTSTR lpszId, DWORD dwSize);
BOOL __declspec(dllimport) WINAPI MBR_RegIdxGetDatabasePath(LONG nIdx, LPTSTR lpszPath, DWORD dwSize);
BOOL __declspec(dllimport) WINAPI MBR_RegIdxGetDatabaseLabel(LONG nIdx, LPTSTR lpszLabel, DWORD dwSize);
LONG __declspec(dllimport) WINAPI MBR_RegIdxGetDatabaseIndex(LPCTSTR lpszID);
LONG __declspec(dllimport) WINAPI MBR_RegIdxGetDefaultDatabase();
}

#endif