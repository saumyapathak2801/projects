// textalkDoc.cpp : implementation of the CTextalkDoc class
//

#include "stdafx.h"
#include "textalk.h"

#include "textalkDoc.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CTextalkDoc

IMPLEMENT_DYNCREATE(CTextalkDoc, CDocument)

BEGIN_MESSAGE_MAP(CTextalkDoc, CDocument)
	//{{AFX_MSG_MAP(CTextalkDoc)
		// NOTE - the ClassWizard will add and remove mapping macros here.
		//    DO NOT EDIT what you see in these blocks of generated code!
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CTextalkDoc construction/destruction

CTextalkDoc::CTextalkDoc()
{
	// TODO: add one-time construction code here

}

CTextalkDoc::~CTextalkDoc()
{
}

BOOL CTextalkDoc::OnNewDocument()
{
	if (!CDocument::OnNewDocument())
		return FALSE;

	((CEditView*)m_viewList.GetHead())->SetWindowText(NULL);

	// TODO: add reinitialization code here
	// (SDI documents will reuse this document)

	return TRUE;
}



/////////////////////////////////////////////////////////////////////////////
// CTextalkDoc serialization

void CTextalkDoc::Serialize(CArchive& ar)
{
	// CEditView contains an edit control which handles all serialization
	((CEditView*)m_viewList.GetHead())->SerializeRaw(ar);
}

/////////////////////////////////////////////////////////////////////////////
// CTextalkDoc diagnostics

#ifdef _DEBUG
void CTextalkDoc::AssertValid() const
{
	CDocument::AssertValid();
}

void CTextalkDoc::Dump(CDumpContext& dc) const
{
	CDocument::Dump(dc);
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CTextalkDoc commands
