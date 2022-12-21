function atualizaContatos() {
    
	loading();

    $.post("integracaoNectarContatos.php?operacao=atualizar",
        function(data) {
            if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Contatos Atualizados!',
                    'success'
                )
				loading();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
				loading();
            }

        });
}

function atualizaFeedbacks() {
    
	loading();

    $.post("integracaoNectarFeedback.php?operacao=atualizar",
        function(data) {
            if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Feedbacks Atualizados!',
                    'success'
                )
				loading();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
				loading();
            }

        });
}

function atualizaOportunidades() {
    
	loading();

    $.post("integracaoNectarOportunidades.php?operacao=atualizar",
        function(data) {
            if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Oportunidades Atualizadas!',
                    'success'
                )
				loading();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
				loading();
            }

        });
}



function exportaContatos() {
	window.location.href = "integracaoNectarContatos.php?operacao=exportar";
}
function exportaFeedbacks() {
	window.location.href = "integracaoNectarFeedback.php?operacao=exportar";
}
function exportaOportunidades() {
	window.location.href = "integracaoNectarOportunidades.php?operacao=exportar";
}




function removeChapa(id) {
    loading();

    $.post("controlaEleicoes.php?operacao=excluiChapa", { idChapa: id, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível excluir o registro, existem votações para esta chapa',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Chapa excluida com Sucesso!',
                    'success'
                )
				loading();
                chamaChapasEleicao();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }

        });

    
    chamaChapasEleicao();

}

function chapas(operacao) {


	var url_string = window.location.href; 
	var url = new URL(url_string);
	var idEleicao = url.searchParams.get("id");
	
    var data = $('#dadosChapas').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaEleicoes.php?operacao=' + operacao+'&idEleicao='+idEleicao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                        'Sucesso',
                        'Registro atualizado com Sucesso!',
                        'success'
                    )
                    //alert(data);
                    $("#modalChapa").modal('hide');
					//document.getElementById("#nomeChapa").value = "";
					//document.getElementById("#descricaoChapa").value = "";
                    //$("#sucesso").fadeIn(1000);
                    //$("#sucesso").fadeOut(2000);
                    //document.getElementById('nome').value = "";
                    //setTimeout(function(){ location.reload(); }, 1500);
            }
            loading();
        }
    });
    
    chamaChapasEleicao();
}

function eleicoes(operacao) {
	var ok = false;
    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaEleicoes.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
				ok = true;
                Swal.fire(
                        'Sucesso',
                        'Registro atualizado com Sucesso!',
                        'success'
                    )
                    //alert(data);
                    //$("#modalTela").modal('hide');
                    //$("#sucesso").fadeIn(1000);
                    //$("#sucesso").fadeOut(2000);
                    //document.getElementById('nome').value = "";
                    //setTimeout(function(){ location.reload(); }, 1500);
            }
            loading();
        }
    });
	if(operacao=='editarEleicao'){
		//setTimeout(function(){ location.reload(); }, 1500);
	}else{
		if(ok){
			document.getElementById("dados").reset();
		}
	}
    chamaListarEleicoes();
}

//nao usar
function mudaStatus(id) {

    

    var valor = $("#sta" + id).val();

    $.post("controlaArquivos.php?operacao=mudaStatus", { id: id, valor: valor, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível ativar',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Registro Alterado com Sucesso!',
                    'success'
                )
                chamaListarTransportadoras();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }
            chamaListarTudo();
            
        });

    if (valor == '0') {
        var valor = $("#sta").val('1');
        $("#ico").removeClass();
        $("#ico").addClass("fa fa-check-circle fa-2x");
    } else {
        var valor = $("#sta").val('0');
        $("#ico").removeClass();
        $("#ico").addClass("fa fa-exclamation-circle fa-2x");
    }

    
}



function mudaStatusPlano(id) {

    loading();

    var valor = $("#sta" + id).val();

    $.post("controlaPlanos.php?operacao=mudaStatus", { id: id, valor: valor, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível ativar',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Registro Alterado com Sucesso!',
                    'success'
                )
                chamaListarPlanos();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }
            chamaListarPlanos();
            loading();
        });

    if (valor == '0') {
        var valor = $("#sta").val('1');
        $("#ico").removeClass();
        $("#ico").addClass("fa fa-check-circle fa-2x");
    } else {
        var valor = $("#sta").val('0');
        $("#ico").removeClass();
        $("#ico").addClass("fa fa-exclamation-circle fa-2x");
    }

    
}

function mudaStatusCliente(id) {

    loading();

    var valor = $("#sta" + id).val();

    $.post("controlaClientes.php?operacao=mudaStatus", { id: id, valor: valor, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível ativar',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Registro Alterado com Sucesso!',
                    'success'
                )
                chamaListarTudo();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }
            chamaListarTudo();
            loading();
        });

    if (valor == '0') {
        var valor = $("#sta").val('1');
        $("#ico").removeClass();
        $("#ico").addClass("fa fa-check-circle fa-2x");
    } else {
        var valor = $("#sta").val('0');
        $("#ico").removeClass();
        $("#ico").addClass("fa fa-exclamation-circle fa-2x");
    }

    
}

function planos(operacao) {

    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaPlanos.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != '0') {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            }else{
                Swal.fire(
                    'Suceeeesso',
                    'Registro inserido com Sucesso!',
                    'success'
                )
            }
            loading();
        }
        
    });
    
    chamaListarTudo();
}

function clientes(operacao) {

    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaClientes.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != '0') {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Registro inserido com Sucesso!',
                    'success'
                )
            }
           loading(); 
        }
    });
    
    chamaListarTudo();
}

function usuarios(operacao) {

    var senha = $("#senha").val();
    var contraSenha = $("#contraSenha").val();

    if (senha != contraSenha) {
        Swal.fire(
            'ERRO!',
            'As senhas informadas não conferem!',
            'error'
        )
        return false;
    }

    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaUsuarios.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro inserido com Sucesso!',
                    'success'
                )
                document.getElementById("dados").reset();
            }
            loading();
        }
    });
    
    listaUsuariosEmpresa();

}

function setores(operacao) {

    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaSetores.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    chamaListarTudo();
}


function modais(operacao) {

    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaModais.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });

    document.getElementById("dados").reset();
    chamaListarTudoModais();



}

function deletaModais(id) {

    loading();

    $.post("controlaModais.php?operacao=excluir", { id: id, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível excluir o registro, existem transportadoras utilizando esta Modal',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Registro excluido com Sucesso!',
                    'success'
                )
                chamaListarTransportadoras();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }
        loading();
        });
    chamaListarTudoModais();
    
}

function aliquotasEmpresa(operacao) {

    var data = $('#dadosAliquota').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaAliquotas.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    chamaListarTudo();
}




function detalhesTransportadoraEmpresaTaxas(operacao) {

    var data = $('#dadosTaxas').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaEmpresas.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    chamaListarTudo();
}


function detalhesTransportadoraEmpresa(operacao) {

    var data = $('#dados').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaEmpresas.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    chamaListarTudo();
}


function empresasDadosGerais(operacao) {

    var data = $('#dadosGerais').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaEmpresas.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    chamaListarTudo();
}



function ativaVinculoTransportadora(id) {
    loading();

    $.post("controlaEmpresas.php?operacao=ativaVinculoTransportadora", { id: id, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível vincular o registro, existem empresas utilizando esta transportadora',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Transportadora vinculada com Sucesso!',
                    'success'
                )
                chamaListarTransportadoras();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }
        loading();
        });

    
    listaTransportadorasVinculadas();

}

function desativaVinculoTransportadora(id) {
    loading();

    $.post("controlaEmpresas.php?operacao=desativaVinculoTransportadora", { id: id, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível desvincular o registro, existem empresas utilizando esta transportadora',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Transportadora desvinculada com Sucesso!',
                    'success'
                )
                chamaListarTransportadoras();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }
        loading();
        });

    
    listaTransportadorasVinculadas();

}

function transpEmpresas(operacao) {

    var data = $('#dadosTransp').serialize();
    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaEmpresas.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    listaTransportadorasVinculadas();
    $('#modalVinculoTransportadora').modal('toggle');
}

function transportadoras(operacao) {


    var data = $('#dados').serialize();


    loading();
    $.ajax({
        type: "POST",
        async: false,
        url: 'controlaTransportadoras.php?operacao=' + operacao,
        data: data, // serializes the form's elements.
        success: function(data) {
            if (data != 0) {
                Swal.fire(
                    'ERRO!',
                    data,
                    'error'
                )
            } else if (data == 0) {
                Swal.fire(
                    'Sucesso',
                    'Registro atualizado com Sucesso!',
                    'success'
                )
            }
            loading();
        }
    });
    
    chamaListarTransportadoras();
}

