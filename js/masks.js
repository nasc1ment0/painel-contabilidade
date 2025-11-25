$(document).ready(function() {
    // Máscara para CPF/CNPJ
    // Delegação de eventos para elementos dinâmicos
    $(document).on('input', '.mask-cpf', function() {
        let valor = $(this).val().replace(/\D/g, '');
        
        if (valor.length <= 11) {
            // CPF: 000.000.000-00
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        
        $(this).val(valor);
    });

    // Delegação de eventos para CNPJ
    $(document).on('input', '.mask-cnpj', function() {
        let valor = $(this).val().replace(/\D/g, '');
        
        if (valor.length <= 14) {
            // CNPJ: 00.000.000/0000-00
            valor = valor.replace(/^(\d{2})(\d)/, '$1.$2');
            valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            valor = valor.replace(/\.(\d{3})(\d)/, '.$1/$2');
            valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
        }
        
        $(this).val(valor);
    });


    // Máscara para telefone fixo (10 dígitos)
    $('.maskTel').on('input', function() {
        let valor = $(this).val().replace(/\D/g, '');
        
        if (valor.length <= 10) {
            // Fixo: (00) 0000-0000
            valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
            valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
            valor = valor.replace(/(-\d{4})\d+?$/, '$1');
        }
        
        $(this).val(valor);
    });

    // Máscara para telefone celular (11 dígitos)
    $('.maskCel').on('input', function() {
        let valor = $(this).val().replace(/\D/g, '');
        
        if (valor.length <= 11) {
            // Celular: (00) 00000-0000
            valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
            valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
            valor = valor.replace(/(-\d{4})\d+?$/, '$1');
        }
        
        $(this).val(valor);
    });
});