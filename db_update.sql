#20131026商品详细属性
ALTER TABLE  `home_shop_content`
ADD  `pinpai` VARCHAR( 20 ) NOT NULL ,
ADD  `xinghao` VARCHAR( 20 ) NOT NULL ,
ADD  `chicun` VARCHAR( 20 ) NOT NULL ,
ADD  `yanse` VARCHAR( 20 ) NOT NULL ,
ADD  `goucheng` VARCHAR( 20 ) NOT NULL ,
ADD  `caizhi` VARCHAR( 20 ) NOT NULL ,
ADD  `zhongliang` VARCHAR( 20 ) NOT NULL ,
ADD  `anquan` VARCHAR( 20 ) NOT NULL ,
ADD  `zhiliang` VARCHAR( 20 ) NOT NULL ,
ADD  `biaozhun` VARCHAR( 20 ) NOT NULL ,
ADD  `gongyi` VARCHAR( 20 ) NOT NULL ,
ADD  `peijian` VARCHAR( 20 ) NOT NULL ,
ADD  `jishucaishu` VARCHAR( 100 ) NOT NULL ,
ADD  `qita` VARCHAR( 100 ) NOT NULL ;

#20131105 加上商品会员价
ALTER TABLE  `home_shop_content` ADD  `huiyuan_price` DOUBLE NOT NULL DEFAULT  '0' COMMENT  '会员价';