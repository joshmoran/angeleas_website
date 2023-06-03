let btn0 = document.getElementById( 'home0' )
let btn1 = document.getElementById( 'home1' )
let btn2 = document.getElementById( 'home2' )


function carousel () {
    btnSelect = this.id

    bannerImg = document.getElementById( 'banner' )

    if ( btnSelect == 'home0' ) {
        banner.src = './src/img/banner/0.jpg'
    } else if ( btnSelect == 'home1' ) {
        banner.src = './src/img/banner/1.jpg'
    } else if ( btnSelect == 'home2' ) {
        banner.src = './src/img/banner/2.jpg'
    } else {

    }
}

// btn0.addEventListener( , carousel() )


btn0.addEventListener( 'click', carousel )
btn1.addEventListener( 'click', carousel )
btn2.addEventListener( 'click', carousel )