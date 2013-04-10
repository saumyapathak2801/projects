// textalk.cpp : Defines the class behaviors for the application.

#include "stdafx.h"
#include "textalk.h"

#include "MainFrm.h"
#include "textalkDoc.h"
#include "textalkView.h"

#include "text.h"
#include "mbrplay.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif


/////////////////////////////////////////////////////////////////////////////
// CTextalkApp

BEGIN_MESSAGE_MAP(CTextalkApp, CWinApp)
	//{{AFX_MSG_MAP(CTextalkApp)
	ON_COMMAND(ID_APP_ABOUT, OnAppAbout)
		// NOTE - the ClassWizard will add and remove mapping macros here.
		//    DO NOT EDIT what you see in these blocks of generated code!
	//}}AFX_MSG_MAP
	// Standard file based document commands
	ON_COMMAND(ID_FILE_NEW, CWinApp::OnFileNew)
	ON_COMMAND(ID_FILE_OPEN, CWinApp::OnFileOpen)
	// Standard print setup command
	ON_COMMAND(ID_FILE_PRINT_SETUP, CWinApp::OnFilePrintSetup)
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CTextalkApp construction

CTextalkApp::CTextalkApp()
{
	// Add construction code here,
	// Place all significant initialization in InitInstance
}

/////////////////////////////////////////////////////////////////////////////
// The one and only CTextalkApp object

CTextalkApp theApp;

/////////////////////////////////////////////////////////////////////////////
// CTextalkApp initialization

BOOL CTextalkApp::InitInstance()
{
	AfxEnableControlContainer();

	// Standard initialization
	// If you are not using these features and wish to reduce the size
	//  of your final executable, you should remove from the following
	//  the specific initialization routines you do not need.

#ifdef _AFXDLL
	Enable3dControls();			// Call this when using MFC in a shared DLL
#else
	Enable3dControlsStatic();	// Call this when linking to MFC statically
#endif

	// Change the registry key under which our settings are stored.
	// You should modify this string to be something appropriate
	// such as the name of your company or organization.
	SetRegistryKey(_T("Local AppWizard-Generated Applications"));

	LoadStdProfileSettings(); //Load standard INI file options (including MRU)

	// Register the application's document templates.  Document templates
	//  serve as the connection between documents, frame windows and views.

	CSingleDocTemplate* pDocTemplate;
	pDocTemplate = new CSingleDocTemplate(
		IDR_MAINFRAME,
		RUNTIME_CLASS(CTextalkDoc),
		RUNTIME_CLASS(CMainFrame),       // main SDI frame window
		RUNTIME_CLASS(CTextalkView));
	AddDocTemplate(pDocTemplate);

	// Parse command line for standard shell commands, DDE, file open
	CCommandLineInfo cmdInfo;
	ParseCommandLine(cmdInfo);

	// Dispatch commands specified on the command line
	if (!ProcessShellCommand(cmdInfo))
		return FALSE;

	// The one and only window has been initialized, so show and update it.
	m_pMainWnd->ShowWindow(SW_SHOW);
	m_pMainWnd->UpdateWindow();

	return TRUE;
}

/////////////////////////////////////////////////////////////////////////////
// CAboutDlg dialog used for App About

class CAboutDlg : public CDialog
{
public:
	CAboutDlg();

// Dialog Data
	//{{AFX_DATA(CAboutDlg)
	enum { IDD = IDD_ABOUTBOX };
	BOOL	m_prosody;
	float	m_pitch;
	float	m_duration;
	long	m_freq;
	int		m_primary_stress;
	int		m_secondary_stress;
	int		m_max_pitch;
	int		m_min_pitch;
	int		m_n_pitch;
	//}}AFX_DATA

	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CAboutDlg)
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	//}}AFX_VIRTUAL

// Implementation
protected:
	//{{AFX_MSG(CAboutDlg)
	DECLARE_EVENTSINK_MAP()
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

CAboutDlg::CAboutDlg() : CDialog(CAboutDlg::IDD)
{
	extern char prosody_flag;
	extern float pitch_ratio;
	extern float duration_ratio;
	extern long voice_freq;
	extern int primary_stress;
	extern int secondary_stress;
	extern int max_pitch;
	extern int min_pitch;
	extern int n_pitch;
	//{{AFX_DATA_INIT(CAboutDlg)
	m_prosody = prosody_flag;
	m_pitch = pitch_ratio;
	m_duration = duration_ratio;
	m_freq = voice_freq;
	m_primary_stress = primary_stress;
	m_secondary_stress = secondary_stress;
	m_max_pitch = max_pitch;
	m_min_pitch = min_pitch;
	m_n_pitch = n_pitch;
	//}}AFX_DATA_INIT
}

void CAboutDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CAboutDlg)
	DDX_Check(pDX, IDC_CHECK1, m_prosody);
	DDX_Text(pDX, IDC_EDIT1, m_pitch);
	DDV_MinMaxFloat(pDX, m_pitch, 0.3f, 3.f);
	DDX_Text(pDX, IDC_EDIT2, m_duration);
	DDV_MinMaxFloat(pDX, m_duration, 0.1f, 10.f);
	DDX_Text(pDX, IDC_EDIT3, m_freq);
	DDV_MinMaxLong(pDX, m_freq, 4000, 64000);
	DDX_Text(pDX, IDC_EDIT4, m_primary_stress);
	DDV_MinMaxInt(pDX, m_primary_stress, 0, 200);
	DDX_Text(pDX, IDC_EDIT6, m_secondary_stress);
	DDV_MinMaxInt(pDX, m_secondary_stress, 0, 200);
	DDX_Text(pDX, IDC_EDIT5, m_max_pitch);
	DDV_MinMaxInt(pDX, m_max_pitch, 80, 500);
	DDX_Text(pDX, IDC_EDIT7, m_min_pitch);
	DDV_MinMaxInt(pDX, m_min_pitch, 50, 400);
	DDX_Text(pDX, IDC_EDIT8, m_n_pitch);
	DDV_MinMaxInt(pDX, m_n_pitch, 50, 500);
	//}}AFX_DATA_MAP
}

BEGIN_MESSAGE_MAP(CAboutDlg, CDialog)
	//{{AFX_MSG_MAP(CAboutDlg)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

// App command to run the dialog
// This runs the dialog, then gets the new values of the variables
// and sets the appropriate functions.
void CTextalkApp::OnAppAbout()
{
	CAboutDlg aboutDlg;
	extern char prosody_flag;
	extern float pitch_ratio;
	extern float duration_ratio;
	extern long voice_freq;
	extern int primary_stress;
	extern int secondary_stress;
	extern int max_pitch;
	extern int min_pitch;
	extern int n_pitch;

	aboutDlg.DoModal();

	primary_stress = aboutDlg.m_primary_stress;
	secondary_stress = aboutDlg.m_secondary_stress;
	max_pitch = aboutDlg.m_max_pitch;
	min_pitch = aboutDlg.m_min_pitch;
	n_pitch = aboutDlg.m_n_pitch;
	prosody_flag = aboutDlg.m_prosody;
	pitch_ratio = aboutDlg.m_pitch;
	duration_ratio = aboutDlg.m_duration;
	voice_freq = aboutDlg.m_freq;
	MBR_SetDurationRatio(aboutDlg.m_duration);
	MBR_SetPitchRatio(aboutDlg.m_pitch);
	MBR_SetVoiceFreq(aboutDlg.m_freq) == 0;
}

/////////////////////////////////////////////////////////////////////////////
// CTextalkApp commands

BEGIN_EVENTSINK_MAP(CAboutDlg, CDialog)
    //{{AFX_EVENTSINK_MAP(CAboutDlg)
	//}}AFX_EVENTSINK_MAP
END_EVENTSINK_MAP()

