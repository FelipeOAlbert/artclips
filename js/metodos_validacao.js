	/*
		Métodos de validação customizados
	*/
	$.validator.addMethod("required", $.validator.methods.required, "");
	$.validator.addMethod("dateBR", function(value, element) {
		// Se não há nenhuma entrada, retornamos verdadeiro pois o campo pode ser opcional
		if(value.length==0) return true;
		//contando chars
		if(value.length!=10) return false;
		// verificando data
		var data		  = value;
		var dia			= data.substr(0,2);
		var barra1		= data.substr(2,1);
		var mes			= data.substr(3,2);
		var barra2		= data.substr(5,1);
		var ano			= data.substr(6,4);

		if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
		if((mes==4||mes==6||mes==9||mes==11)&&dia==31)return false;
		if(mes==2 && (dia>29||(dia==29&&ano%4!=0)))return false;
		if(ano < 1900)return false;

		return true;
	}, "");
	
	$.validator.addMethod("non_zero", function(value, element){
		if(value==0)
			return false;
		else
			return true;
	}, "");
	
	function valida_cpf(value, element){
		value = value.replace('.','');
		value = value.replace('.','');
		cpf = value.replace('-','');
		while(cpf.length < 11) cpf = "0"+ cpf;
		var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
		var a = [];
		var b = new Number;
		var c = 11;
		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i);
			if (i < 9) b += (a[i] * --c);
		}
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		b = 0;
		c = 11;
		for (y=0; y<10; y++) b += (a[y] * c--);
		if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
		return true;
	};
	
	function valida_cnpj(cnpj, element) {
		cnpj = jQuery.trim(cnpj);// retira espaços em branco
		// DEIXA APENAS OS NÚMEROS
		cnpj = cnpj.replace('/','');
		cnpj = cnpj.replace('.','');
		cnpj = cnpj.replace('.','');
		cnpj = cnpj.replace('-','');
	 
		var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
		digitos_iguais = 1;
	 
		if (cnpj.length < 14 && cnpj.length < 15){
			return false;
		}
		for (i = 0; i < cnpj.length - 1; i++){
			if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
				digitos_iguais = 0;
				break;
			}
		}
	 
		if (!digitos_iguais){
			tamanho = cnpj.length - 2
			numeros = cnpj.substring(0,tamanho);
			digitos = cnpj.substring(tamanho);
			soma = 0;
			pos = tamanho - 7;
	 
			for (i = tamanho; i >= 1; i--){
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2){
					pos = 9;
				}
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(0)){
				return false;
			}
			tamanho = tamanho + 1;
			numeros = cnpj.substring(0,tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--){
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2){
					pos = 9;
				}
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(1)){
				return false;
			}
			return true;
		}else{
			return false;
		}
	};
	
	function valida_cpf_cnpj(value, element) {
		if (valida_cpf(value, element) || valida_cnpj(value, element)) {
			return true;
		} else {
			return false;
		}
	}
	
	function valida_combo(value, element) {
		if (is_empty(value)) {
			return false;
		} else {
			return true;
		}
	}
	
	function valida_repetir_campo(value, element) {
		var str_pos = $(element).attr('id').search(/-repita/i);
		
		if (str_pos == -1) {
			if ( 
					$('#' + $(element).attr('id') + '-repita').val() == value ||
					$('#' + $(element).attr('id') + '-repita').val() == ''
				)
				return true;
		} else {
			var id = $(element).attr('id').substring(0, str_pos);
			if ( $('#' + id).val() == value || $('#' + id).val() == '')
				return true;
		}
		
		return false;
	}
	
	$.validator.addMethod("repita", valida_repetir_campo, "");
	$.validator.addMethod("combo", valida_combo, "");
	$.validator.addMethod("cpf_cnpj", valida_cpf_cnpj, "");
	$.validator.addMethod("cpf", valida_cpf, "");
	$.validator.addMethod("cnpj", valida_cnpj, "Informe um CNPJ válido."); // Mensagem padrão
