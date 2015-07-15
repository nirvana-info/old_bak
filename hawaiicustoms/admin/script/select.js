var xmlhttp;

function showBrand(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getfolder.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function showSeries(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getseries.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged()
{
if (xmlhttp.readyState==4)
{
//document.getElementById("vendorid").innerHTML=xmlhttp.responseText;
}
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

/*function Checkvalue(str)
{
    var phpUrl = 'getparent.php';
    $.ajax(
    {
        url: phpUrl,
        type: 'GET', 
        cache: false,
        dataType: 'text',
        data: { catid: str },
        error: function(){
            //  alert('Error loading XML document');
        },
        success: function(html)
        {
            if(html == 'wrong')
            {
                alert("Sorry, You can not add products to the root category.");
                $('#ISSelectReplacement_'+str).attr('checked',false);
                $('#category_old'+str).attr('selected',false);
                $('#ISSelectcategory_'+str).removeClass("SelectedRow");
            }
        }
    }
    );
}

function Checkbulkvalue(str,pid)
{
    var phpUrl = 'getparent.php';
    $.ajax(
    {
        url: phpUrl,
        type: 'GET', 
        cache: false,
        dataType: 'text',
        data: { catid: str },
        error: function(){
            //  alert('Error loading XML document');
        },
        success: function(html)
        {
            if(html == 'wrong')
            {
                alert("Sorry, You can not add products to the root category.");
//                $('#ISSelectReplacement_'+str).attr('checked',false);
                $('#ISSelectcategory_'+pid+'_'+str+' > input').attr('checked',false);                
                $('#category_'+pid+'_'+str).attr('selected',false);
                $('#ISSelectcategory_'+pid+'_'+str).removeClass("SelectedRow");
            }
        }
    }
    );
}*/

function Checkbulkvalue(str)
{
    var phpUrl = 'getparent.php';
    var cid = str.split('_');
    var pid = cid[1];    
    var catid = cid[2];
    if(cid.length == 3)
    {
        $.ajax(
        {
            url: phpUrl,
            type: 'GET', 
            cache: false,
            dataType: 'text',
            data: { catid: catid },
            error: function(){
                //  alert('Error loading XML document');
            },
            success: function(html)
            {
                if(html == 'wrong')
                {
                    alert("Sorry, You can not add products to the root category.");
    //                $('#ISSelectReplacement_'+str).attr('checked',false);
                    $('#ISSelectcategory_'+pid+'_'+catid+' > input').attr('checked',false);                
                    $('#category_'+pid+'_'+catid).attr('selected',false);
                    $('#ISSelectcategory_'+pid+'_'+catid).removeClass("SelectedRow");
                }
            }
        }
        );
    }
    else {
        $.ajax(
        {
            url: phpUrl,
            type: 'GET', 
            cache: false,
            dataType: 'text',
            data: { catid: pid },
            error: function(){
                //  alert('Error loading XML document');
            },
            success: function(html)
            {
                if(html == 'wrong')
                {
                    alert("Sorry, You can not add products to the root category.");
                    $('#ISSelectReplacement_'+pid).attr('checked',false);
                    $('#category_old'+pid).attr('selected',false);
                    $('#ISSelectcategory_'+pid).removeClass("SelectedRow");
                }
            }
        }
        );
    }
}