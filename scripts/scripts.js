$(function(){
	//confirm that the user really wants to delete
	$('.deleteButton').click(function(){
		var warn = confirm("This will delete all data for the selected surveys.  This cannot be reversed. Do you wish to proceed?");
		if(warn==true){
			$('#tables').submit();	
		}else{
			window.stop();
		}
	});

	//confirm with the root user that they want to proceed with the selected action
	$('.deleteUser').click(function(){
		var action = $('.userDropdown').attr('value');
		var warn = confirm("Are you sure you want to "+action+" the selected users?");
		if(warn==true){
			$('#editUsers').submit();	
		}else{
			window.stop();
		}
	});

	//Make sure that the passwords entered match
	$('.addUserSubmit').click(function(){
		var addPass = $('.addPass').attr('value');
		var checkPass = $('.checkPass').attr('value');
		if(addPass==checkPass){
			$('#addNewUser').submit();
		}else{
			alert("The passwords do not match.");
			$('.checkPass').attr('value', '');
			$('.addPass').attr('value', '');
		}

	});

	//Toggle between searching for new users and resetting the search list
	$('.searchText').keypress(function(){
		var searchField = $('.searchText').attr('value');
		if (searchField==""){
			$('.searchButton').attr('value', 'Reset');
		}else{
			$('.searchButton').attr('value', 'Search');
		}
	});


	//Reload the user's table list so that the download link will reflect newly download data
	//Also, so the created txt file can be deleted
	$('a.new').click(function(){
		setTimeout("location.reload(true);", 2500);
	});
	$('a.old').click(function(){
		setTimeout("location.reload(true);", 2500);
	});


	$('.popUp').hide();

	$('.addUser').click(function(){
		$('.popUp').fadeIn(300);
		$('#wrapper').animate({opacity:.3},500);
	});

	$('.xbut').click(function(){
		$('#form').hide();
		$('#wrapper').animate({opacity:1},200);
	});

	var footer = '<footer class="bottom"> &copy 2012 Scott Batson  </footer>';

	$(footer).appendTo('body');

});