
export default class Funciones {

	showAlerta(text){
		alert(text);
	}

	async base64(file) {
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
}