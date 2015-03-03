debug = function (log_txt) {
    if (window.console != undefined) {
        console.log(log_txt);
    }
}

$(document).ready(function() { 
  
    //Set values of search textfields 
    var placeholdersID = {
        keywords:"Search Recipe Titles", 
        addRecipeInput: "Search Recipe Names", 
        recipeName: "Search Recipe By Name", 
        addArticleInput : "Search Article By Name",                           
        usernameInput : "username", 
        recipeKeywordsInput: "keyword, title",
        articleName:"Article Name",
        userEmail:"Enter the full email address of the user you would like to add"
    };
  
    //Set values of search textfields 
    $.each(placeholdersID, function(id, val) { 
        //Set Starting Values
        $('#'+id).val(val);
        //Removes text on focus for textfield
        $('#'+id).focus(function(){
            if($(this).val() == val)
                $(this).val('');
        });
        //Replaces textfield with value if still empty
        $('#'+id).blur(function(){
            if ($(this).val() == '')
                $(this).val(val);
        });
    });
  
    // BEGIN: popup
    $("#open_popup").click(function(){
        $(".popup").removeClass("hide");
    });
    $("#close_popup").click(function(){
        $(".popup").addClass("hide");
    });
    // END: popup
});

//Index Sponsor Update
//Sponsor Dropdown
function addSponsor(obj, url){  
    var id = $(obj).parents("li").attr("id");
    $(obj).parent().html(function(){
        $(obj).parent().load(url, {
            itemId:id
        })
        });
}
//Sponsor Update
function updateSponsor(obj, url, itemId){ 
    var sponsorId = obj.options[obj.selectedIndex].value;    
    $(obj).parent().html(function(){
        $(obj).parent().load(url, {
            itemId:itemId, 
            sponsorId:sponsorId
        });
    });    
}

/* Forms */

//Right Sidebox Sponsor Update
function editUpdateSponsor(url, itemId){ 
    var sponsorId = $("#sponsors option:selected").val();  
    $("#currentSponsor").html(function(){
        $("#currentSponsor").load(url, {
            itemId:itemId, 
            sponsorId:sponsorId
        });
    });    
}

//Checkbox Update






