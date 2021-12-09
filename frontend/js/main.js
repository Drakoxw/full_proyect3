axios.defaults.headers.post['Content-Type'] ='application/json;charset=utf-8';
axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

const URL_api = 'http://localhost';
const htmlTabla = document.getElementById('tabla_cont');
const HtmlInput = document.getElementById('formFileSm');
const HtmlImg = document.getElementById('img_d');
const HtmlForm = document.getElementById('form_post');
const HtmlModal = document.getElementById('bg_modal');
const HtmlImgBase = document.getElementById('img_base');
const btnSub = document.getElementById('sumit');
 
let id_img = '';
let id_doc = '';
btnSub.textContent = 'Enviar';

function getImg(id){
  let base;
  axios.get(`${URL_api}/archivo/${id}` )
  .then(res => {
    console.log(res);
    base = res.data.base
    HtmlModal.style.display = 'block';
    HtmlImgBase.src = base;
  });
}

function cerrarModal(){
  HtmlModal.style.display = 'none';
}

function setEdit(id){
  document.getElementById('sumit').textContent = 'Editar Archivos';
  axios.get(`${URL_api}/productos/${id}` )
  .then(res => {
    let dat = res.data[id];
    console.log(dat);
    id_doc = dat.referencia;
    document.getElementById('nombre_prod').value = dat.nombre_producto;
    document.getElementById('desc_prod').value = dat.observaciones;
    document.getElementById('valor').value = dat.precio;
    document.getElementById('cantidad').value = dat.cantidad;
    document.getElementById('tax').value = dat.impuesto;
    document.getElementById('estado').value = dat.estado;
  });
}

const base64 = async function (file) {
	return new Promise((resolve, reject) => {
		try {
			const reader= new FileReader()
			reader.readAsDataURL(file);
			reader.onload = () => {
				resolve({
					blob: file,
					base: reader.result,
				});

			};
			reader.onerror = (err) => {
				resolve({
					blob: file,
					base: null,
				});
				console.log('err', err);
			};
		} catch (err) {
			reject(err)
			return null;
		}
	})
}

const postImg= async function(img) {
	let data = {
		base: img.base,
		tipo: img.blob.type,
		name: img.blob.name,
		ext: String(img.blob.name).split('.')[1],
	}
  axios.post(`${URL_api}/archivo`,data )
  .then(res => console.log(res));
	
}

const enviarDatos = function () {
	let nombre_producto = document.getElementById('nombre_prod').value;
	let observaciones = document.getElementById('desc_prod').value;
	let precio = document.getElementById('valor').value;
	let cantidad = document.getElementById('cantidad').value;
	let impuesto = document.getElementById('tax').value;
	let estado = document.getElementById('estado').value;
  const boton = document.getElementById('sumit').textContent; 
  let data = {
    nombre_producto,
    observaciones,
    precio,
    cantidad,
    impuesto,
    estado,
    imagen : HtmlInput.files[0] ? HtmlInput.files[0].name: '' ,
    ruta_imagen: id_img
  }
  if (boton == 'Enviar') {
    if (HtmlInput.files[0]) {
      if (nombre_producto,observaciones,precio,
          cantidad,impuesto,estado) {
        axios.post(`${URL_api}/productos`,data )
        .then(res => {
          console.log(res);
          HtmlForm.reset();
          HtmlInput.value = null;
          HtmlImg.src = '';
          getAllDatos();
        }).catch(err => console.log('err', err));
      }
    } else {
      alert('Falta la imagen');
    }
  } else if (boton == 'Editar Archivos') {
    if (!HtmlInput.files[0]) {
      delete data.imagen;
    }
    axios.patch(`${URL_api}/productos/${id_doc}`,data )
    .then(res => {
      console.log(res);
      HtmlForm.reset();
      HtmlInput.value = null;
      HtmlImg.src = '';
      getAllDatos();
      id_doc = '';
    }).catch(err => console.log('err', err));
  }
	
}



const getAllDatos = () => {
	let dataFetch = [];
  fetch(`${URL_api}/productos`)
  .then(r => r.json())
  .then(data => {
    if (data) {
			for (const k in data) {
				const el = data[k];
				dataFetch.push(el);
			}
		}
		console.log('data', dataFetch);
		printData(dataFetch)
  })
	.catch(err => console.log('err',err));
}

const printData = (data) => {
	let tablaContent = '';
	data.forEach(el => {
		tablaContent += `
		<tr>
			<th scope="row">${el.referencia}</th>
			<td>${el.nombre_producto}</td>
			<td>${el.observaciones}</td>
			<td>${el.precio}</td>
			<td>${el.estado}</td>
			<td>${el.cantidad}</td>
			<td>${el.impuesto}</td>
			<td>
				<button type="button" class="btn btn-success btn_click" 
          data-id="${el.ruta_imagen}" onclick="getImg(${el.ruta_imagen})" >
					Ver Img
				</button>
			</td>
			<td>
				<button type="button" class="btn btn-warning" onclick="setEdit(${el.referencia})" >
					Editar
				</button>
				<button type="button" class="btn btn-danger ml-2">
					Eliminar
				</button>
			</td>
		</tr>
		`
	});
	htmlTabla.innerHTML = tablaContent;
}
////////////////// EVENTOS //////////////////


HtmlForm.addEventListener('submit', (ev) => {
	ev.preventDefault();
	enviarDatos();
});

HtmlInput.addEventListener('change', () => {
	const file = HtmlInput.files[0];
	base64(file).then(res => {
		HtmlImg.src = res.base;
		postImg(res);
	});
}) 

document.addEventListener('DOMContentLoaded', () => {
	getAllDatos();
})