//Função para remover caracteres especiais dos campos de texto
function valida_caracteres(f) {
!(/^[a-z\u00E0-\u00E4;\u00E7-\u00EF;\u00F2-\u00F6;\u00F9-\u00FC;\u002E;\u002C;0-9\s]*$/i).test(f.value)?f.value = f.value.replace(/[^a-z\u00E0-\u00E4;\u00E7-\u00EF;\u00F2-\u00F6;\u00F9-\u00FC;\u002E;\u002C;0-9\s]/ig,''):null;
} 