
const Api = 'http://localhost:80/productos';
const htmlTabla = document.getElementById('tabla_cont');
const HtmlInput = document.getElementById('formFileSm');
const HtmlImg = document.getElementById('img_d');
const BtnEnviar = document.getElementById('sumit');
const HtmlForm = document.getElementById('form_post');


const getAllDatos = () => {
	let dataFetch = [];
	fetch(Api)
	.then(resp => resp.json())
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
				<button type="button" class="btn btn-success">
					Ver Img
				</button>
			</td>
			<td>
				<button type="button" class="btn btn-warning">
					Editar
				</button>
			</td>
		</tr>
		`
	});
	htmlTabla.innerHTML = tablaContent;
}

function enviarDatos() {
	let nombre_producto = document.getElementById('nombre_prod').value;
	let observaciones = document.getElementById('desc_prod').value;
	let precio = document.getElementById('valor').value;
	let cantidad = document.getElementById('cantidad').value;
	let impuesto = document.getElementById('tax').value;
	let estado = document.getElementById('estado').value;
	if (HtmlInput.files[0]) {
		let name = HtmlInput.files[0].name;
		let data = {
			nombre_producto,
			observaciones,
			precio,
			cantidad,
			impuesto,
			estado,
			imagen : name,
			ruta_imagen:'ruta/xres/'+ name
		}
		if (nombre_producto,observaciones,precio,
				cantidad,impuesto,estado,name) {
					console.log(data);
				fetch(Api, {
					method: "POST",
					body: JSON.stringify(data)
				}).then(() => {
					HtmlForm.reset();
					HtmlInput.value = null;
					HtmlImg.src = '';
					getAllDatos();
				})
				.catch(err => console.log('err', err));
		} else {
			alert('Falta Datos');
		}
	} else {
		alert('Falta la imagen');
	}
}

async function base64(file) {
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

HtmlForm.addEventListener('submit', (ev) => {
	ev.preventDefault();
	enviarDatos();
});

HtmlInput.addEventListener('change', () => {
	const file = HtmlInput.files[0];
	base64(file).then(res => {
		HtmlImg.src = res.base;
		console.log('base:', res.base);
	});
}) 

window.onload = () => {
    console.log('inicianco app');
    getAllDatos();
}