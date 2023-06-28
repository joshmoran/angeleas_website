<<<<<<< HEAD
function changeAddress () {
    let value = document.getElementById( 'whichAddress' ).value
    window.open( 'account_details.php?address=' + value )
=======
function  changeAddressBtn() {
    let address = document.getElementById('selectAddress').value;
    let addressRows = document.getElementsByClassName('hiddenAddress');

    for (let i = 0; i < addressRows.length; i++) {
        addressRows[i].style.display = 'block';
    }

    let addressFrame  = document.createElement('IFRAME');
    let frameLocation = document.getElementById('selectAddress');

    addressFrame.setAttribute('src', 'account_details-address_frame.php?select=' . address ); 
    addressFrame.setAttribute('width', '500px');
    addressFrame.setAttribute('height', '500px');   
    
    frameLocation.appendChild(addressFrame);
>>>>>>> b7511c585ee1eb451fa57c6b4cad40a60ea77f1b
}