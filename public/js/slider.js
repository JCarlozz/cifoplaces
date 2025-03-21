var i=0;

var fotos=['imagenes/avatar.jpg', 'imagenes/increibles.jpg', 'imagenes/capitan.jpg', 'imagenes/furiosa.jpg', 'imagenes/up.jpg' ];

function mostrar(){
	imatge1.src=fotos[i];
	imatge2.src=fotos[(i+1)%fotos.length];
	imatge3.src=fotos[(i+2)%fotos.length];

}

window.onload=function(){

	botonNext.onclick=function(){
		i=(i+1)%fotos.length;
		mostrar();
	}

	botonBack.onclick=function(){
		i=((i-1)+fotos.length)%fotos.length;
		mostrar();
	}

	mostrar();
}