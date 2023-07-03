function changeAddress () {
    let value = document.getElementById( 'whichAddress' ).value
    window.open( 'account_details.php?address=' + value,'_self' )
}