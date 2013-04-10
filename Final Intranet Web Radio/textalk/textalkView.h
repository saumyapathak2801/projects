// textalkView.h : interface of the CTextalkView class
//
/////////////////////////////////////////////////////////////////////////////

#if !defined(AFX_TEXTALKVIEW_H__CE3C5F8D_62ED_11D2_A882_0020AF68E0A5__INCLUDED_)
#define AFX_TEXTALKVIEW_H__CE3C5F8D_62ED_11D2_A882_0020AF68E0A5__INCLUDED_

#if _MSC_VER >= 1000
#pragma once
#endif // _MSC_VER >= 1000

class CTextalkView : public CEditView
{
protected: // create from serialization only
	CTextalkView();
	DECLARE_DYNCREATE(CTextalkView)

// Attributes
public:
	CTextalkDoc* GetDocument();

// Operations
public:

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CTextalkView)
	public:
	virtual void OnDraw(CDC* pDC);  // overridden to draw this view
	virtual BOOL PreCreateWindow(CREATESTRUCT& cs);
	protected:
	virtual BOOL OnPreparePrinting(CPrintInfo* pInfo);
	virtual void OnBeginPrinting(CDC* pDC, CPrintInfo* pInfo);
	virtual void OnEndPrinting(CDC* pDC, CPrintInfo* pInfo);
	//}}AFX_VIRTUAL

// Implementation
public:
	virtual ~CTextalkView();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:

// Generated message map functions
protected:
	//{{AFX_MSG(CTextalkView)
	afx_msg void OnSpeak();
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

#ifndef _DEBUG  // debug version in textalkView.cpp
inline CTextalkDoc* CTextalkView::GetDocument()
   { return (CTextalkDoc*)m_pDocument; }
#endif

/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Developer Studio will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_TEXTALKVIEW_H__CE3C5F8D_62ED_11D2_A882_0020AF68E0A5__INCLUDED_)
