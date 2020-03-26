<%@ WebHandler Language="VB" Class="savecontent" %>

Imports System
Imports System.Web
Imports System.IO
Imports System.Web.SessionState
Public Class savecontent : Implements IHttpHandler, IRequiresSessionState
 
    Public Sub ProcessRequest(ByVal context As HttpContext) Implements IHttpHandler.ProcessRequest
        
        context.Response.ContentType = "text/html"

        Dim sContent As String = System.Uri.UnescapeDataString(context.Request("content")).ToString
        Dim sMainCss As String = System.Uri.UnescapeDataString(context.Request("mainCss")).ToString
        Dim sSectionCss As String = System.Uri.UnescapeDataString(context.Request("sectionCss")).ToString
        
        Try
            
            'You can save the content into a database. In this example we save the content in a session variable.
            context.Session("content") = sContent
            context.Session("mainCss") = sMainCss
            context.Session("sectionCss") = sSectionCss

            'context.Response.Write("success")
            
        Catch ex As Exception
        
            context.Response.Write(ex.Message)
            
        End Try

    End Sub
 
    Public ReadOnly Property IsReusable() As Boolean Implements IHttpHandler.IsReusable
        Get
            Return False
        End Get
    End Property

End Class