

var xmlHttp
function changeprice(it)
 { 
con= confirm("ARE YOU SURE YOU WANT TO NULLIFY TRANSACTION ?");
if(con==false){it.checked=''}else{

if(it.checked==true){value="yes"} 
if(it.checked==false) {return }

//alert ("type  is"+type +"value is "+value)


xmlHttp=GetXmlHttpObject()
 if(xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  }

 //var valu=it.value;
//alert ("Browser does not support HTTP Request");

var url="nullifier.php"
 url=url+"?name="+it.id;
 url=url+"&value="+value;
 url=url+"&sid="+Math.random()
it.disabled='disabled';
xmlHttp.onreadystatechange=stateChanged 
 xmlHttp.open("GET",url,true)
 xmlHttp.send(null);
alert(url);
}
 
 }
 
 
 
function stateChanged() 
{ 

if (xmlHttp.readyState==4 )
{

 }
}


function GetXmlHttpObject()
 { 
 var objXMLHttp=null
 if (window.XMLHttpRequest)
  {
  objXMLHttp=new XMLHttpRequest()
  }
 else if (window.ActiveXObject)
  {
  objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
  }
 return objXMLHttp
 }
