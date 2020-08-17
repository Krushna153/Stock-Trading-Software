<?php
//3.1.1 - NotwwwDir

// translated by František Bartoš (Bart, admin@bart.cz)

$langues = array(
	'langue' => 'Czech',
	'locale' => 'czech',
	'addVirtual' => 'Přidat VirtualHost',
	'backHome' => 'Zpět na WAMPSERVER Přehled',
	'VirtualSubMenuOn' => 'Položka <code>sub-menu VirtualHost</code> musít být nastavena na (Zobrazit) v nabídce <code>Wamp nastavení</code> - pravé kontextové tlačítko myši. Poté znovu obnovte tuto stránku',
	'UncommentInclude' => 'Odkomentujte <small>(odstraňte #)</small> na řádku <code>#Include conf/extra/httpd-vhosts.conf</code><br> v souboru %s',
	'FileNotExists' => 'Soubor <code>%s</code> neexistuje',
	'FileNotWritable' => 'Soubor <code>%s</code> není zapisovatelný',
	'DirNotExists' => '<code>%s</code> neexistuje nebo není adresář',
	'NotwwwDir' => 'Adresář <code>%s</code> je vyhrazen pro "localhost". Použijte prosím jiný (nový) adresář.',
	'NotCleaned' => '<code>%s</code> soubor nebyl vyčištěn.<br>Zde jde příklad pro VirtualHost: dummy-host.example.com',
	'NoVirtualHost' => 'Neexistuje žádný VirtualHost definovaný v <code>%s</code><br>VirtualHost by měl být vytvořen alespoň pro localhost.',
	'NoFirst' => 'První VirtualHost musí být <code>localhost</code> v souboru <code>%s</code>',
	'ServerNameInvalid' => 'ServerName <code>%s</code> je neplatný.',
	'LocalIpInvalid' => 'Místní IP adresa <code>%s</code> je neplatná.',
	'VirtualHostName' => '<code>Název</code> pro  <code>Virtual Host</code>  Žádné mezery - Žádné podtržítko(_) ',
	'VirtualHostFolder' => 'Kompletní a absolutní <code>cesta</code> k <code>adresáři</code> s <code>projektem</code> pro VirtualHost  <i>Příklady: C:/wamp/www/projekt/ nebo E:/www/stranky1/</i> ',
	'VirtualHostIP' => '<code class="option">Jestliže</code> chcete pro VirtualHost použít IP adresu: <code class="option">místní IP adresa</code> 127.x.y.z ',
	'VirtualHostPort' => '<code class="option">Jestliže</code> chcete použít "Port pro naslouchání" jiný než výchozí <code class="option">Povolené porty</code> %s',
	'VirtualHostPortNone' => 'Pokud chcete použít jiný "Port naslouchaní" než výchozí, je nutné přejít na položku "Nastavit port pro naslouchání Apache", kterou naleznete pod kontextovou nabídkou Nástroje. ',
  'VirtualAlreadyExist' => 'ServerName <code>%s</code> již existuje',
	'VirtualIpAlreadyUsed' => 'Místní IP adresa <code>%s</code> již existuje',
	'VirtualPortNotExist' => 'Port <code>%s</code> není "Port pro naslouchání" Apache',
	'VirtualPortExist' => 'Port <code>%s</code> je výchozí "Port pro naslouchání" Apache a neměl by být měněn',
	'VirtualHostExists' => 'VirtualHost byl již definován pro:',
	'Start' => 'Vytvořit VirtualHost (může chvíli trvat...)',
	'GreenErrors' => 'Chyby, které jsou označeny zeleně, mohou být opraveny automaticky.',
	'Correct' => 'Spustit automatickou opravu chyb, které jsou označeny zeleně.',
	'NoModify' => 'Nelze měnit soubory <code>httpd-vhosts.conf</code> nebo <code>hosts</code>',
	'VirtualCreated' => 'Soubory byly upraveny. Virtual host <code>%s</code> byl vytvořen',
	'CommandMessage' => 'Zprávy z konzole pro aktualizaci DNS:',
	'However' => 'Můžete přidat další VirtualHost zvolením položky "Přidat VirtualHost".<br>Pro nově vytvořené VirtualHost je nutné vzít v úvahu to, že je potřeba spustit položku <code>Restartovat DNS</code><br> - kliknutím kontextového tlačítka myši v nabídce Nástroje. <i>(Tento proces se bohužel nedá provést automaticky)</i>',
	'suppForm' => 'Formulář pro odstranění VirtualHost',
	'suppVhost' => 'Odstranit VirtualHost',
	'Required' => 'Vyžadováno',
	'Optional' => 'Volitelné',
	);
?>