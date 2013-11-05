<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function load_split_word_array( )
{
				global $xingDB;
				global $xing2DB;
				global $CiYuDB;
				$xing = "";
				$i = 0;
				for ( ;	$i < strlen( $xing );	++$i	)
				{
								$xingDB[$xing[$i].$xing[$i + 1]] = 1;
								++$i;
				}
				$xing2s = explode( ",", "欧阳,上官,端木,南宫,谯笪,轩辕,令狐,钟离,闾丘,长孙,鲜于,宇文,司徒,司空,公孙,西门,东门,左丘,东郭,呼延,慕容,司马,夏侯,诸葛,东方,赫连,皇甫,尉迟,申屠" );
				foreach ( $xing2s as $name )
				{
								$xing2DB[$name] = 1;
				}
				$filename = PHP168_PATH."inc/ciyu.dat";
				if ( $handle = fopen( $filename, "rb" ) )
				{
								flock( $handle, LOCK_SH );
								$filedata = fread( $handle, filesize( $filename ) );
								fclose( $handle );
								$array = explode( "\r\n", $filedata );
								$ss = "<?php ";
								foreach ( $array as $key => $value )
								{
												if ( $value )
												{
																$CiYuDB[$value] = 1;
												}
								}
				}
}

function splitword( $str = "" )
{
				if ( $str != "" )
				{
								$Source_String = trim( split_getstring( trim( $str ) ) );
				}
				if ( $Source_String == "" )
				{
								return "";
				}
				$Source_String = split_getstring( $Source_String );
				$spwords = explode( " ", $Source_String );
				$spLen = count( $spwords );
				$space = " ";
				$i = $spLen - 1;
				for ( ;	0 <= $i;	--$i	)
				{
								if ( trim( $spwords[$i] ) == "" )
								{
												continue;
								}
								if ( ord( $spwords[$i][0] ) < 128 )
								{
												if ( ereg( "[^0-9\\.\\+\\-]", $spwords[$i] ) )
												{
																$Result_String = $spwords[$i].$space.$Result_String;
												}
												else
												{
																$nextword = "";
																@$nextword = @substr( $Result_String, 0, @strpos( $Result_String, " " ) );
																if ( ereg( "^年|月|日|时|分|秒|点|元|百|千|万|亿|位|辆|只|篇", $nextword ) )
																{
																				$Result_String = $spwords[$i].$Result_String;
																}
																else
																{
																				$Result_String = $spwords[$i].$space.$Result_String;
																}
												}
								}
								else
								{
												$c = $spwords[$i][0].$spwords[$i][1];
												$n = hexdec( bin2hex( $c ) );
												if ( $c == "《" )
												{
																$Result_String = $spwords[$i].$space.$Result_String;
												}
												else if ( 41279 < $n && $n < 43584 )
												{
																$Result_String = $spwords[$i].$space.$Result_String;
												}
												else if ( strlen( $spwords[$i] ) <= 4 )
												{
																if ( ereg( "的|和|是\$", $spwords[$i], $regs ) )
																{
																				$spwords[$i] = ereg_replace( $regs[0]."\$", "", $spwords[$i] ).$space.$regs[0];
																}
																if ( !ereg( "^年|月|日|时|分|秒|点|元|百|千|万|亿|位|辆|只|篇", $spwords[$i] ) || $i == 0 )
																{
																				$Result_String = $spwords[$i].$space.$Result_String;
																}
																else
																{
																				$Result_String = $spwords[$i - 1].$spwords[$i].$space.$Result_String;
																				--$i;
																}
												}
												else
												{
																$Result_String = split_getwords( $spwords[$i] ).$space.$Result_String;
												}
								}
				}
				return $Result_String;
}

function split_getwords( $str )
{
				global $CiYuDB;
				$space = " ";
				$spLen = strlen( $str );
				$WordArray = array( );
				$i = $spLen - 1;
				for ( ;	0 <= $i;	)
				{
								if ( $i <= 3 )
								{
												if ( $i == 1 )
												{
																$WordArray[] = substr( $str, 0, 2 );
												}
												else
												{
																$w = substr( $str, 0, 4 );
																if ( strlen( $w ) < 13 && $CiYuDB[$w] )
																{
																				$WordArray[] = $w;
																}
																else
																{
																				$WordArray[] = substr( $str, 2, 2 );
																				$WordArray[] = substr( $str, 0, 2 );
																}
												}
												$i = -1;
												break;
								}
								if ( 13 <= $i )
								{
												$maxPos = 13;
								}
								else
								{
												$maxPos = $i;
								}
								$isMatch = false;
								$j = $maxPos;
								for ( ;	0 <= $j;	$j = $j - 2	)
								{
												$w = substr( $str, $i - $j, $j + 1 );
												if ( strlen( $w ) < 13 && $CiYuDB[$w] )
												{
																$WordArray[] = $w;
																$i = $i - $j - 1;
																$isMatch = true;
																break;
												}
								}
								if ( !!$isMatch && !( 1 < $i ) )
								{
												$WordArray[] = $str[$i - 1].$str[$i];
												$i = $i - 2;
								}
				}
				$rsStr = split_duanluo( $WordArray );
				return $rsStr;
}

function split_duanluo( $WordArray )
{
				global $xingDB;
				global $xing2DB;
				$CnSgNum = "一|二|三|四|五|六|七|八|九|十|百|千|万|亿|数|两";
				$wlen = count( $WordArray ) - 1;
				$space = " ";
				$i = $wlen;
				for ( ;	0 <= $i;	--$i	)
				{
								if ( ereg( $CnSgNum, $WordArray[$i] ) )
								{
												$rsStr .= $space.$WordArray[$i];
												if ( 0 < $i && ereg( "^年|月|日|时|分|秒|点|元|百|千|万|亿|位|辆|只|篇", $WordArray[$i - 1] ) )
												{
																$rsStr .= $WordArray[$i - 1];
																--$i;
												}
												else
												{
																while ( 0 < $i && ereg( $CnSgNum, $WordArray[$i - 1] ) )
																{
																				$rsStr .= $WordArray[$i - 1];
																				--$i;
																}
												}
												continue;
								}
								if ( strlen( $WordArray[$i] ) == 4 && isset( $xing2DB[$WordArray[$i]] ) )
								{
												$rsStr .= $space.$WordArray[$i];
												if ( 0 < $i && strlen( $WordArray[$i - 1] ) == 2 )
												{
																$rsStr .= $WordArray[$i - 1];
																--$i;
																if ( 0 < $i && strlen( $WordArray[$i - 1] ) == 2 )
																{
																				$rsStr .= $WordArray[$i - 1];
																				--$i;
																}
												}
								}
								else if ( strlen( $WordArray[$i] ) == 2 && isset( $xingDB[$WordArray[$i]] ) )
								{
												$rsStr .= $space.$WordArray[$i];
												if ( 0 < $i && strlen( $WordArray[$i - 1] ) == 2 )
												{
																$rsStr .= $WordArray[$i - 1];
																--$i;
																if ( 0 < $i && strlen( $WordArray[$i - 1] ) == 2 )
																{
																				$rsStr .= $WordArray[$i - 1];
																				--$i;
																}
												}
								}
								else
								{
												$rsStr .= $space.$WordArray[$i];
								}
				}
				$rsStr = preg_replace( "/^".$space."/", "", $rsStr );
				return $rsStr;
}

function split_getstring( $str )
{
				$space = " ";
				$slen = strlen( $str );
				if ( $slen == 0 )
				{
								return "";
				}
				$prechar = 0;
				$i = 0;
				for ( ;	$i < $slen;	++$i	)
				{
								if ( ord( $str[$i] ) < 129 )
								{
												if ( ord( $str[$i] ) < 33 )
												{
																if ( $prechar != 0 && $str[$i] != "\r" && $str[$i] != "\n" )
																{
																				$strings .= $space;
																}
																$prechar = 0;
																continue;
												}
												else if ( ereg( "[^0-9a-zA-Z@\\.%#:/\\&_-]", $str[$i] ) )
												{
																if ( $prechar == 0 )
																{
																				$strings .= $str[$i];
																				$prechar = 3;
																}
																else
																{
																				$strings .= $space.$str[$i];
																				$prechar = 3;
																}
												}
												else if ( $prechar == 2 || $prechar == 3 )
												{
																$strings .= $space.$str[$i];
																$prechar = 1;
												}
												else if ( ereg( "@#%:", $str[$i] ) )
												{
																$strings .= $str[$i];
																$prechar = 3;
												}
												else
												{
																$strings .= $str[$i];
																$prechar = 1;
												}
								}
								else
								{
												if ( $prechar != 0 && $prechar != 2 )
												{
																$strings .= $space;
												}
												if ( isset( $str[$i + 1] ) )
												{
																$c = $str[$i].$str[$i + 1];
																if ( ereg( "％|＋|－|０|１|２|３|４|５|６|７|８|９|．", $c ) )
																{
																				$strings .= split_replacenum( $c );
																				$prechar = 2;
																				++$i;
																				continue;
																}
																$n = hexdec( bin2hex( $c ) );
																if ( 41279 < $n && $n < 43584 )
																{
																				if ( $c == "《" )
																				{
																								if ( $prechar != 0 )
																								{
																												$strings .= $space." 《";
																								}
																								else
																								{
																												$strings .= " 《";
																								}
																								$prechar = 2;
																				}
																				else
																				{
																								if ( $c == "》" )
																								{
																												$strings .= "》 ";
																												$prechar = 3;
																								}
																								else
																								{
																												if ( $prechar != 0 )
																												{
																																$strings .= $space.$c;
																												}
																												else
																												{
																																$strings .= $c;
																												}
																												$prechar = 3;
																								}
																				}
																}
																else
																{
																				$strings .= $c;
																				$prechar = 2;
																}
																++$i;
												}
								}
				}
				return $strings;
}

function split_replacenum( $fnum )
{
				$nums = array( "０", "１", "２", "３", "４", "５", "６", "７", "８", "９", "＋", "－", "％", "．" );
				$fnums = "0123456789+-%.";
				$i = 0;
				for ( ;	$i < count( $nums );	++$i	)
				{
								if ( $nums[$i] == $fnum )
								{
												return $fnums[$i];
								}
				}
				return $fnum;
}

load_split_word_array( );
?>
