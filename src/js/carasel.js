noOfBtns = 3

for ( a = 0; a <= noOfBtns; a++ ) {
    document.getElementById( "home" + a ).addEventListener( "click", function () {
        alert( a )
        document.getElementById( "myModal" ).style.display = "block"
    } )
}