// textalkDoc.h : interface of the CTextalkDoc class
//
/////////////////////////////////////////////////////////////////////////////

#if !defined(AFX_TEXTALKDOC_H__CE3C5F8B_62ED_11D2_A882_0020AF68E0A5__INCLUDED_)
#define AFX_TEXTALKDOC_H__CE3C5F8B_62ED_11D2_A882_0020AF68E0A5__INCLUDED_

#if _MSC_VER >= 1000
#pragma once
#endif // _MSC_VER >= 1000


class CTextalkDoc : public CDocument
{
protected: // create from serialization only
	CTextalkDoc();
	DECLARE_DYNCREATE(CTextalkDoc)

// Attributes
public:

// Operations
public:

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CTextalkDoc)
	public:
	virtual BOOL OnNewDocument();
	virtual void Serialize(CArchive& ar);
	//}}AFX_VIRTUAL

// Implementation
public:
	virtual ~CTextalkDoc();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:

// Generated message map functions
protected:
	//{{AFX_MSG(CTextalkDoc)
		// NOTE - the ClassWizard will add and remove member functions here.
		//    DO NOT EDIT what you see in these blocks of generated code !
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Developer Studio will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_TEXTALKDOC_H__CE3C5F8B_62ED_11D2_A882_0020AF68E0A5__INCLUDED_)
