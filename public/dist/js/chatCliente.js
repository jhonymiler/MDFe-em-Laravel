var getUrl = window.location;
var socket = io.connect( 'http://' + getUrl.host + ':3000' );

var usuario = {
    sala: $( "#chat-mensagem" ).attr( 'sala' ),
    nome: $( "#chat-mensagem" ).attr( 'name' ),
    imagem: $( "#chat-mensagem" ).attr( 'img' ),
    empresa: $( "#chat-mensagem" ).attr( 'empresa' ),
    bot: true
}

// Evento enviado quando o usuário insere um apelido
socket.emit( "entrar", usuario, function ( dados ) {} );

// Resposta ao envio de mensagens do servidor
socket.on( "mensagens", function ( dados ) {
    exibeMsg( dados );
} );

//Printar Mensagens na Tela
function exibeMsg( dados ) {
    var m;
    var n;
    var t;
    var d = new Date();
    dataHora = ( d.toLocaleString() );
    if ( dados.nome == usuario.nome ) {
        m = "right";
        n = 'right';
        t = 'left';
    } else {
        m = "left";
        n = 'left';
        t = 'right';

        if ( !dados.bot ) {
            $( "#qtdUsuarios" ).hide( 500 );
        }
    }

    text = '<div class="msg" >' +
        '<div class="direct-chat-msg ' + m + '">' +
        '<div class="direct-chat-infos clearfix">' +
        '<span class="direct-chat-name float-' + n + '">' + dados.nome + '</span>' +
        '<span class="direct-chat-timestamp float-' + t + '">' + dataHora + 'Hs</span>' +
        '</div>' +
        '<img class="direct-chat-img" src="' + dados.imagem + '" alt="' + dados.nome + '">' +
        '<div class="direct-chat-text">' + dados.texto + '</div>' +
        '</div></div>';
    $( "#ChatMensagens" ).append( text ).animate( {
        scrollTop: $( "#ChatMensagens" ).prop( "scrollHeight" )
    }, 500 );
}

$( "#enviaMsg" ).submit( function () {
    if ( $( "#chat-mensagem" ).val() != '' ) {

        var msg = {
            'sala': usuario.sala,
            'nome': $( "#chat-mensagem" ).attr( 'name' ),
            'imagem': $( "#chat-mensagem" ).attr( 'img' ),
            'texto': $( "#chat-mensagem" ).val()
        };
        $( "#slide-smile" ).removeClass( "direct-chat-contacts-open" );

        // Evento acionado no servidor para o envio da mensagem
        // junto com o nome do usuário selecionado da lista
        socket.emit( "mensagens", msg, function () {
            $( "#chat-mensagem" ).val( '' ).focus();
        } );

    }
    return false;

} );

$( "#smiles" ).disMojiPicker();

$( "#smiles" ).picker( emoji => $( "#chat-mensagem" ).val( $( "#chat-mensagem" ).val() + emoji ) );
twemoji.parse( document.body );

var d = new Date();
dataHora = ( d.toLocaleString() );
$( ".direct-chat-timestamp" ).html( dataHora );

$( "#chatContainer" ).hide();
$( "#chatbuttom" ).click( function () {
    $( "#chatContainer" ).show( 200 );
    $( "#chatbuttom" ).hide();

    if ( $( this ).attr( 'conectado' ) == 0 ) {
        // Evento enviado quando o usuário insere um apelido
        socket.emit( "conectar", usuario.sala, function ( dados ) {} );
    }
} );
$( "#fechaChat" ).click( function () {
    $( "#chatbuttom" ).show();
    $( "#chatContainer" ).hide( 200 );
} );