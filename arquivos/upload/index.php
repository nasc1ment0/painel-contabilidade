<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Upload de Arquivos</h5>
    </div>
    <div class="card-body">
        <form id="formUpload" method="POST" action="index.php?rotina=5&mod=1" enctype="multipart/form-data">
            <input type="hidden" name="modo_envio" id="modo_envio">
            <!-- Seleção do Cliente -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="cliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                    <input type="text" id="nm_cliente" placeholder="Digite para buscar clientes..."
                        class="form-control input-sm">
                    <input type="hidden" id="id_cliente" name="id_cliente">
                </div>
            </div>

            <!-- Upload de Arquivos -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="arquivos" class="form-label">Arquivos <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="arquivos" name="arquivos[]" multiple>
                </div>
            </div>

            <!-- Botão Upload -->
            <div class="row justify-content-center" style="text-align:center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-50" id="btn-upload" style="font-size: 20px;">
                        <i class="bi bi-envelope-arrow-up"></i> Enviar
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {

        // AUTOCOMPLETE CLIENTE
        $("#nm_cliente").autocomplete({
            source: "funcoes/buscas/buscaCliente.php",
            minLength: 2,
            select: function (event, ui) {
                $("#id_cliente").val(ui.item.id_cliente);
            }
        });

        // SUBMIT VIA AJAX
        $("#formUpload").on("submit", function (e) {
            e.preventDefault();

            let idCliente = $("#id_cliente").val().trim();
            let arquivos = $("#arquivos")[0].files.length;
            let erros = [];

            if (!idCliente) erros.push("Selecione um cliente válido.");
            if (arquivos === 0) erros.push("Selecione pelo menos um arquivo.");

            if (erros.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Verifique os dados',
                    html: `<ul style="text-align:left">${erros.map(e => `<li>${e}</li>`).join("")}</ul>`
                });
                return;
            }

            Swal.fire({
                title: 'Envio dos arquivos',
                html: `
                        <div class="d-flex justify-content-center gap-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="opcaoEnvio" id="opcaoEmail" value="T" checked>
                                <label class="form-check-label" for="opcaoEmail">
                                    Enviar email
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="opcaoEnvio" id="opcaoNuvem" value="N">
                                <label class="form-check-label" for="opcaoNuvem">
                                    Apenas salvar na nuvem
                                </label>
                            </div>
                        </div>

                        <div id="camposEmail">
                            <div class="mb-3 text-start">
                                <label class="form-label">Tipo de mensagem</label>
                                <select id="tipoMensagem" class="form-select"></select>
                            </div>

                            <div class="mb-2 text-start">
                                <label class="form-label">Mensagem</label>
                                <textarea id="mensagemEmail" class="form-control" rows="3"
                                    placeholder="Digite a mensagem do email..."></textarea>
                            </div>
                        </div>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    const toggleCampos = () => {
                        const envioEmail = document.getElementById('opcaoEmail').checked;
                        document.getElementById('camposEmail').style.display = envioEmail ? 'block' : 'none';
                    };

                    document.getElementById('opcaoEmail').addEventListener('change', toggleCampos);
                    document.getElementById('opcaoNuvem').addEventListener('change', toggleCampos);

                    toggleCampos();
                    
                    $.ajax({
                        url: "funcoes/buscas/buscaMensagem.php",
                        type: "GET",
                        dataType: "json",
                        success: function (dados) {
                            let select = $("#tipoMensagem");
                            select.empty().append('<option value="">Selecione...</option>');
                            dados.forEach(item => {
                                select.append(`
                                    <option value="${item.id}" data-texto="${item.texto}">
                                        ${item.nome}
                                    </option>
                                `);
                            });
                        },
                        error: function () {
                            Swal.showValidationMessage("Erro ao carregar tipos de mensagem");
                        }
                    });

                    // Preenche o textarea ao trocar o tipo
                    $(document).on("change", "#tipoMensagem", function () {
                        $("#mensagemEmail").val($(this).find(":selected").data("texto") || "");
                    });
                },
                preConfirm: () => {
                    const modo = document.querySelector('input[name="opcaoEnvio"]:checked').value;

                    let retorno = {
                        modo_envio: modo,
                        tipo_mensagem: null,
                        mensagem: null
                    };

                    if (modo === 'T') {
                        retorno.tipo_mensagem = document.getElementById('tipoMensagem').value;
                        retorno.mensagem = document.getElementById('mensagemEmail').value;
                    }

                    return retorno;
                }
            }).then((result) => {

                if (!result.isConfirmed) return;

                $("#modo_envio").val(result.value.modo_envio);

                // LOADING
                Swal.fire({
                    title: 'Processando...',
                    text: 'Enviando arquivos, aguarde',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                let formData = new FormData($("#formUpload")[0]);

                // se quiser já enviar agora:
                formData.append('tipo_mensagem', result.value.tipo_mensagem);
                formData.append('mensagem_email', result.value.mensagem);

                $.ajax({
                    url: $("#formUpload").attr("action"),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tudo certo!',
                            text: 'Os arquivos foram enviados com sucesso.',
                            confirmButtonText: 'OK'
                        });

                        $("#formUpload")[0].reset();
                        $("#id_cliente").val("");
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao enviar os arquivos.'
                        });
                    }
                });

            });
        })
    })
</script>
