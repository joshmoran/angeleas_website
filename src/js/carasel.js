let btn0 = document.getElementById( 'home0' )
let btn1 = document.getElementById( 'home1' )
let btn2 = document.getElementById( 'home2' )

let interval = 3000
function carousel () {
    btnSelect = this.id

    bannerImg = document.getElementById( 'banner' )

    if ( btnSelect == 'home0' ) {
        banner.src = './src/img/banner/0.jpg'
        btn0.firstChild.src = './src/img/banner/selected.jpg'
        btn1.firstChild.src = './src/img/banner/unselected.jpg'
        btn2.firstChild.src = './src/img/banner/unselected.jpg'
    } else if ( btnSelect == 'home1' ) {
        banner.src = './src/img/banner/1.jpg'
        btn0.firstChild.src = './src/img/banner/unselected.jpg'
        btn1.firstChild.src = './src/img/banner/selected.jpg'
        btn2.firstChild.src = './src/img/banner/unselected.jpg'
    } else if ( btnSelect == 'home2' ) {
        banner.src = './src/img/banner/2.jpg'
        btn0.firstChild.src = './src/img/banner/unselected.jpg'
        btn1.firstChild.src = './src/img/banner/unselected.jpg'
        btn2.firstChild.src = './src/img/banner/selected.jpg'
    } else {
        alert( 'Their was a problem displaying the banner, please try again' )
    }
}


// btn0.addEventListener( , carousel() )


btn0.addEventListener( 'click', carousel )
btn1.addEventListener( 'click', carousel )
btn2.addEventListener( 'click', carousel )