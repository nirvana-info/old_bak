function loadVideo(name)
{               
     $("#slideshow").load("videoobject.php?vidname="+name);
     //self.location='videoobject.php?vidname='+name;
}

$(document).ready(function() {
    %%GLOBAL_FirstVideo%%
});
