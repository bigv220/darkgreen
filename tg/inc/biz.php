<?php
function gettpl( $html, $tplpath = "" )
{
				global $STYLE;
				if ( $tplpath && file_exists( $tplpath ) )
				{
								return $tplpath;
				}
				else if ( $tplpath && file_exists( Mpath.$tplpath ) )
				{
								return Mpath.$tplpath;
				}
				else if ( file_exists( Mpath."template/{$STYLE}/{$html}.htm" ) )
				{
								return Mpath."template/{$STYLE}/{$html}.htm";
				}
				else
				{
								return Mpath."template/default/{$html}.htm";
				}
}

if ( !function_exists( "MODULE_CK" ) )
{
				showerr( "文件不存在！" );
}
//module_ck( "tg" );
?>
