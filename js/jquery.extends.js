$.fn.duplicate = function(count, cloneEvents)
{
	var tmp = [];
	for ( var i = 0; i < count; i++ )
	{
		$.merge( tmp, this.clone( cloneEvents ).get() );
	}
	
	return this.pushStack( tmp );
};

$.fn.ajustInParent = function( map )
{
	for ( i in map )
	{
		var p = $(this).parent().css(i);
		
		if ( typeof(p) == 'string' )
		{
			p = p.replace('px', '');
		}
		
		if ( !isNaN( parseInt(p) ) )
		{
			$(this).css( i, parseInt(p) + map[i] )
		}
	}
	
	return $(this);
}

$.fn.centerInParent = function()
{
	$(this).parent().parent().css('padding', '0px');
	$(this).parent().css('position', 'relative');
	$(this).css('position', 'absolute');
	
	$(this).css('top' , ( ( $(this).parent().height() / 2 ) - ( $(this).height() / 2 ) ) + 'px' );
	$(this).css('left', ( ( $(this).parent().width()  / 2 ) - ( $(this).width()  / 2 ) ) + 'px' );
	
	return $(this);
}

$.fn.showLoad = function( content )
{
	var t = 'Carregando...';
	
	if ( content )
	{
		t = content;
	}
	
	var msg = 
	'<div class="jquery_extends_loading_container">' +
		'<div class="jquery_extends_loading_background"></div>' +
		'<div class="jquery_extends_loading_content" id="jquery_extends_loading_content">' +
			'<div class="jquery_extends_loading_img"></div>' +
			t +
		'</div>' +
	'</div>';
	
	$(this).html(msg);
	
	$(this).find('.jquery_extends_loading_content').centerInParent();
	
	return $(this);
}

$.fn.loading = function( url, data, callback, text )
{
	var t = $(this).params( [ data, callback, text ] , 'string');
	
	$(this).showLoad( t ).scrollIntoView();
	
	var obj = this;
	
	var func = function(responseText, textStatus, XMLHttpRequest)
	{
		// Melhorar isso: execute_callback() não admite passagem de parâmtros
		$(obj).execute_callback( [ url, data, callback ] );
		
		//$(obj).execute_callback( [ url, data, callback ], [ responseText, textStatus, XMLHttpRequest ] );
	}
	
	if ( typeof(data) == 'object' )
	{
		this.load( url, data, func );
	}
	else
	{
		this.load( url, func );
	}
	
	return $(this);
};

/*
$.fn.expandCollapse = function( url, data, callback )
{
	if ( $(this).is('.jquery_extends_collapse') )
	{
		$(this).collapse( true, [ url, data, callback ] );
	}
	else
	{
		$(this).expand( url, data, callback );
	}
	
	return $(this);
};
*/

$.fn.expand = function( url, data, callback, text )
{
	switch ( $(this).get(0).tagName )
	{
		case 'TR':
		{
			//$(this).expand_tr( url, data, callback );
			break;
		}
		case 'TD':
		{
			$(this).expand_td( url, data, callback, text );
			break;
		}
	}
}

$.fn.expand_td = function( url, data, callback, text )
{
	// Adiciona uma linha vazia à tabela
	$(this).parent().after( "<tr><td colspan='100%'></td></tr>" );

	if ( typeof( url ) != 'undefined' )
	{
		$(this).parent().next().children().loading( url, data, callback, text );
	}
	else
	{
		$(this).parent().next().show();
		
		$(this).execute_callback( [ url, data, callback, text ] );
	}
	
	// Inverte as classes, sinalizando a ação atual
	$(this).removeClass('jquery_extends_expand').addClass('jquery_extends_collapse');
}

$.fn.collapse = function( remove, callback )
{
	switch ( $(this).get(0).tagName )
	{
		case 'TD':
		{
			$(this).parent().collapse_next( remove );
			break
		}
		default:
		{
			$(this).collapse_next( remove );
		}
	}
	
	// Inverte as classes, sinalizando a ação atual
	$(this).removeClass('jquery_extends_collapse').addClass('jquery_extends_expand');
	
	$(this).execute_callback( [ remove, callback ] );
}

$.fn.collapse_next = function( remove )
{
	if ( typeof(remove) == 'boolean' && remove )
	{
		$(this).next().remove();
	}
	else
	{
		$(this).next().hide();
	}
}

$.fn.execute_callback = function( funcs, params )
{
	for ( i in funcs )
	{
		if ( typeof( funcs[i] ) == 'function' )
		{
			funcs[i]();
		}
	}
}

$.fn.params = function( params, type )
{
	for ( i in params )
	{
		if ( typeof( params[i] ) == type )
		{
			return params[i];
		}
	}
	
	return false;
}

$.fn.reset = function ()
{
	$(this).each (function(){
		this.reset();
	});
	
	return $(this);
}

$.fn.scrollIntoView = function()
{
	var obj = this;
	
	var scrolling = 0;
	
	var ot = $(this).position().top;
	var oh = $(this).height();
	var wt = $(window).scrollTop();
	var wh = $(window).height();
	
	// Coordenada para centralizar o elemento na janela
	var scrolling = ot - ( ( wh / 2 ) - ( oh / 2 ) );
	
	// Arredonda para um multiplo de 10
	scrolling = Math.round(scrolling / 10) * 10;
	
	// Proteção
	if ( scrolling < 0 )
	{
		scrolling = 0;
	}
	
	scroll_to = function()
	{
		switch ( true )
		{
			// Está em área visível
			//case ( $(obj).position().top < $(window).scrollTop() && ( $(obj).position().top + $(obj).height() ) < ( $(document).height() - $(window).height() ) ):
			
			// Topo da página
			case ( $(window).scrollTop() <= 0 && scrolling <= 0 ):
			
			// Final da página
			case ( $(window).scrollTop() >= ( $(document).height() - $(window).height() ) && scrolling >= $(window).scrollTop() ):
			{
				return $(obj);
			}
			case ( scrolling < $(window).scrollTop() ):
			{
				window.scrollBy(0, -10);
		
				// Arredonda para um multiplo de 10
				$(window).scrollTop( Math.round( $(window).scrollTop() / 10) * 10 );
		
				scrolldelay = setTimeout('scroll_to()', 10);
			
				break;
			}
			case ( scrolling > $(window).scrollTop() ):
			{
				window.scrollBy(0, 10);
		
				// Arredonda para um multiplo de 10
				$(window).scrollTop( Math.round( $(window).scrollTop() / 10) * 10 );
		
				scrolldelay = setTimeout('scroll_to()', 10);
			
				break;
			}
		}
	}
	
	scroll_to();
	
	return $(this);
}

/*

$.fn.scrollIntoView = function( duration, map )
{
	
	var ot = $(this).position().top;
	var oh = $(this).height();
	var wt = $(window).scrollTop();
	var wh = $(window).height();
	
	var top = ot - ( ( wh / 2 ) - ( oh / 2 ) );
	
	// Arredonda para um multiplo de 10
	top = Math.round(top / 10) * 10;
	
	// Proteção
	if ( top < 0 )
	{
		top = 0;
	}
	
	if ( ! Number(duration) || duration <= 100 )
	{
		duration = 100;
	}
	
	var scrolldelay = Math.round( duration / 10 );
	
	var scrollstep  = Math.round( ( wh - top ) / 10 ) * -1;
	
	//console.info(scrollstep);
	
	scroll_to = function()
	{
		if ( $(window).scrollTop() <= 0 || $(window).scrollTop() >= ( $(document).height() - $(window).height() ) )
		{
			console.info( $(document).height() - $(window).scrollTop() );
			return $(this);
		}
		else
		if ( top < $(window).scrollTop() )
		{
			window.scrollBy(0, scrollstep);
		
			// Arredonda para um multiplo de scrollstep
			$(window).scrollTop( Math.round( $(window).scrollTop() / scrollstep ) * scrollstep );
		
			scrolldelay = setTimeout('scroll_to()', scrolldelay);
		}
		else
		if ( top > $(window).scrollTop() )
		{
			window.scrollBy(0, scrollstep);
		
			// Arredonda para um multiplo de scrollstep
			$(window).scrollTop( Math.round( $(window).scrollTop() / scrollstep ) * scrollstep );
		
			scrolldelay = setTimeout('scroll_to()', scrolldelay);
		}
	
		//console.info( 'elem. ' + top + ', win. ' + $(window).scrollTop() );
	}
	
	scroll_to();
}

var static_restore_point = [];

$.fn.restorePoint = function()
{
	static_restore_point[ this ] = $(this).clone();
}

$.fn.restore = function()
{
	$(this).html( static_restore_point[ this ] );
}
*/
