// textalkView.cpp : implementation of the CTextalkView class
//

#include "stdafx.h"
#include "textalk.h"

#include "textalkDoc.h"
#include "textalkView.h"

#include "mbrplay.h"
#include "text.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CTextalkView

IMPLEMENT_DYNCREATE(CTextalkView, CEditView)

BEGIN_MESSAGE_MAP(CTextalkView, CEditView)
	//{{AFX_MSG_MAP(CTextalkView)
	ON_COMMAND(ID_BUTTON32771, OnSpeak)
	//}}AFX_MSG_MAP
	// Standard printing commands
	ON_COMMAND(ID_FILE_PRINT, CEditView::OnFilePrint)
	ON_COMMAND(ID_FILE_PRINT_DIRECT, CEditView::OnFilePrint)
	ON_COMMAND(ID_FILE_PRINT_PREVIEW, CEditView::OnFilePrintPreview)
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CTextalkView construction/destruction

CTextalkView::CTextalkView()
{
	// TODO: add construction code here

}

CTextalkView::~CTextalkView()
{
}

BOOL CTextalkView::PreCreateWindow(CREATESTRUCT& cs)
{
	// TODO: Modify the Window class or styles here by modifying
	//  the CREATESTRUCT cs

	BOOL bPreCreated = CEditView::PreCreateWindow(cs);
	cs.style &= ~(ES_AUTOHSCROLL|WS_HSCROLL);	// Enable word-wrapping

	return bPreCreated;
}

/////////////////////////////////////////////////////////////////////////////
// CTextalkView drawing

void CTextalkView::OnDraw(CDC* pDC)
{
	CTextalkDoc* pDoc = GetDocument();
	ASSERT_VALID(pDoc);

	// TODO: add draw code for native data here
}

/////////////////////////////////////////////////////////////////////////////
// CTextalkView printing

BOOL CTextalkView::OnPreparePrinting(CPrintInfo* pInfo)
{
	// default CEditView preparation
	return CEditView::OnPreparePrinting(pInfo);
}

void CTextalkView::OnBeginPrinting(CDC* pDC, CPrintInfo* pInfo)
{
	// Default CEditView begin printing.
	CEditView::OnBeginPrinting(pDC, pInfo);
}

void CTextalkView::OnEndPrinting(CDC* pDC, CPrintInfo* pInfo)
{
	// Default CEditView end printing
	CEditView::OnEndPrinting(pDC, pInfo);
}

/////////////////////////////////////////////////////////////////////////////
// CTextalkView diagnostics

#ifdef _DEBUG
void CTextalkView::AssertValid() const
{
	CEditView::AssertValid();
}

void CTextalkView::Dump(CDumpContext& dc) const
{
	CEditView::Dump(dc);
}

CTextalkDoc* CTextalkView::GetDocument() // non-debug version is inline
{
	ASSERT(m_pDocument->IsKindOf(RUNTIME_CLASS(CTextalkDoc)));
	return (CTextalkDoc*)m_pDocument;
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CTextalkView message handlers

void CTextalkView::OnSpeak() 
{
	CString tempstr;
	//CTextDoc* tempdoc = GetDocument();
	GetWindowText(tempstr);
	// call the speak routine in textalk
	speak(tempstr);
}
