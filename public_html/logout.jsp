<%
HttpSession session = request.getSession();
  session.invalidate();
%>