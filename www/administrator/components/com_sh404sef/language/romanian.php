<?php

//
// Copyright (C) 2004 W.H.Welch
// All rights reserved.
//
// This source file is part of the 404SEF Component, a Mambo 4.5.1
// custom Component By W.H.Welch - http://sef404.sourceforge.net/
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// Please note that the GPL states that any headers in files and
// Copyright notices as well as credits in headers, source files
// and output (screens, prints, etc.) can not be removed.
// You can extend them with your own credits, though...
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Additions by Yannick Gaultier (c) 2006-2010
// Dont allow direct linking

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

define('COM_SH404SEF_404PAGE','Pagina 404');
define('COM_SH404SEF_ADD','Adaugă');
define('COM_SH404SEF_ADDFILE','Fişier index prestabilit.');
define('COM_SH404SEF_ASC',' (asc) ');
define('COM_SH404SEF_BACK','Înapoi la Panoul de control sh404SEF');
define('COM_SH404SEF_BADURL','Url-ul Non-SEF trebuie să înceapă cu index.php');
define('COM_SH404SEF_CHK_PERMS','Vă rugăm verificaţi permisiunile fişierului şi asiguraţi-vă că acest fişier poate fi citit.');
define('COM_SH404SEF_CONFIG','sh404SEF<br/>Configurare');
define('COM_SH404SEF_CONFIG_DESC','Configurare funcţionalităţile principale sh404SEF. După schimbarea setărilor din această pagină, va trebui cel mai probabil să curătaţi baza de date cu url-urile SEF, astfel încât noile url-uri să fie recreate în conformitate cu parametrii noi pe care îi utilizţi în prezent.Acest lucru se poate face din Manager Url.');
define('COM_SH404SEF_CONFIG_UPDATED','Configurare actualizată');
define('COM_SH404SEF_CONFIRM_ERASE_CACHE', 'Doriţi sa curaţaţi cache URL-uri? Acest lucru este recomandat după schimbarea configurării. Pentru a genera din nou cache-ul, trebuie să vizitaţi iarăşi homepage-ul, sau cel mai bine : generaţi un sitemap pentru site-ul dvs.');
define('COM_SH404SEF_COPYRIGHT','Copyright');
define('COM_SH404SEF_DATEADD','Data adăugării');
define('COM_SH404SEF_DEBUG_DATA_DUMP','Golire DATE REMEDIERE COMPLETATA: Încărcarea paginii terminată');
define('COM_SH404SEF_DEF_404_MSG','<h1>Bad karma: we can\'t find that page!</h1>
<p>You asked for <strong>{%sh404SEF_404_URL%}</strong>, but despite our computers looking very hard, we could not find it. What happened ?</p>
<ul>
<li>the link you clicked to arrive here has a typo in it</li>
<li>or somehow we removed that page, or gave it another name</li>
<li>or, quite unlikely for sure, maybe you typed it yourself and there was a little mistake ?</li>
</ul>
<h4>{sh404sefSimilarUrlsCommentStart}It\'s not the end of everything though : you may be interested in the following pages on our site:{sh404sefSimilarUrlsCommentEnd}</h4>
<p>{sh404sefSimilarUrls}</p>
<p> </p>');
define('COM_SH404SEF_DEF_404_PAGE','Pagina 404 prestabilită');
define('COM_SH404SEF_DESC',' (desc) ');
define('COM_SH404SEF_DISABLED',"<p class='error'>NOTĂ: Suportul SEF in Joomla este momentan dezactivat. Pentru a folosi SEF, vă rugăm să-l activaţi de la <a href='".$GLOBALS['shConfigLiveSite']."/administrator/index.php?option=com_config'>Configurare Globală</a> Setări SEO.</p>");
define('COM_SH404SEF_EDIT','Editeaya');
define('COM_SH404SEF_EMPTYURL','Trebuie să furnizaţi un URL pentru redirecţionare.');
define('COM_SH404SEF_ENABLED','Activat');
define('COM_SH404SEF_ERROR_IMPORT','Eroare în timpul importului:');
define('COM_SH404SEF_EXPORT','Backup URL-uri Personalizate');
define('COM_SH404SEF_EXPORT_FAILED','EXPORT NEREUSIT!!!');
define('COM_SH404SEF_FATAL_ERROR_HEADERS','EROARE FATALĂ: HEADER DEJA TRIMIS');
define('COM_SH404SEF_FRIENDTRIM_CHAR','Curătă caracterele prietenoase');
define('COM_SH404SEF_HELP','sh404SEF<br/>Suport');
define('COM_SH404SEF_HELPDESC','Ai nevoie de ajutor cu sh404SEF?');
define('COM_SH404SEF_HELPVIA','<b>Puteti beneficia de ajutor la urmatoarele forum-uri:</b>');
define('COM_SH404SEF_HIDE_CAT','Ascunde categoria');
define('COM_SH404SEF_HITS','Vizualizări');
define('COM_SH404SEF_IMPORT','Importă URL-uri Personalizate');
define('COM_SH404SEF_IMPORT_EXPORT','Import/Export URL-uri');
define('COM_SH404SEF_IMPORT_OK','URL-urile Personalizate au fost importate cu succes!');
define('COM_SH404SEF_INFO','Documentaţie sh404SEF');
define('COM_SH404SEF_INFODESC','Vezi sumar şi documentaţie Proiect sh404SEF');
define('COM_SH404SEF_INSTALLED_VERS','Versiune instalată:');
define('COM_SH404SEF_INVALID_SQL','Date incorecte în FIŞIER SQL :');
define('COM_SH404SEF_INVALID_URL','URL INVALID: acest link necesită un Itemid valid, dar nu a fost găsit niciunul.<br/>SOLUŢIE: Creaţi un element în meniu pentru acesta. Nu trebuie să-l publicaţi, doar creaţi-l.');
define('COM_SH404SEF_LICENSE','Licentă');
define('COM_SH404SEF_LOWER','Toate cu litere mici');
define('COM_SH404SEF_MAMBERS','Forum membrii');
define('COM_SH404SEF_NEWURL','Url non-SEF');
define('COM_SH404SEF_NO_UNLINK','Nu se poate şterge fişierul încărcat din directorul media');
define('COM_SH404SEF_NOACCESS','Nu se poate accesa');
define('COM_SH404SEF_NOCACHE','nocache');
define('COM_SH404SEF_NOLEADSLASH','The should be NO LEADING SLASH on the New SEF URL');
define('COM_SH404SEF_NOREAD','EROARE FATALĂ: Nu se poate citi fişierul ');
define('COM_SH404SEF_NORECORDS','Nu a fost găsită nici o înregistrare.');
define('COM_SH404SEF_OFFICIAL','Forum oficial proiect');
define('COM_SH404SEF_OK',' OK ');
define('COM_SH404SEF_OLDURL','SEF URL Nou');
define('COM_SH404SEF_PAGEREP_CHAR','Caracter spaţiu pagină');
define('COM_SH404SEF_PAGETEXT','Text pagină');
define('COM_SH404SEF_PROCEED',' Continua ');
define('COM_SH404SEF_PURGE404','Curăţă <br/>Log-urile 404');
define('COM_SH404SEF_PURGE404DESC','Curăţă Log-urile 404');
define('COM_SH404SEF_PURGECUSTOM','Curăţă <br/>Redirecţionări Personalizate');
define('COM_SH404SEF_PURGECUSTOMDESC','Curăţă Redirecţionări Personalizate');
define('COM_SH404SEF_PURGEURL','Curăţă <br/>Url-uri SEF');
define('COM_SH404SEF_PURGEURLDESC','Curăţă Url-uri SEF');
define('COM_SH404SEF_REALURL','Url Real');
define('COM_SH404SEF_RECORD',' înregistrare');
define('COM_SH404SEF_RECORDS',' înregistrări');
define('COM_SH404SEF_REPLACE_CHAR','Caracter de înlocuire');
define('COM_SH404SEF_SAVEAS','Salvează ca Redirecţionare Personalizată');
define('COM_SH404SEF_SEFURL','Url SEF');
define('COM_SH404SEF_SELECT_DELETE','Selectaţi un element pentru a-l şterge');
define('COM_SH404SEF_SELECT_FILE','Vă rugăm selectaţi un fişier mai întâi');
define('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG', 'Activaţi iJoomla magazine în conţinut');
define('COM_SH404SEF_ADV_INSERT_ISO', 'Înscrie cod ISO');
define('COM_SH404SEF_ADV_MANAGE_URL', 'URL procssing');
define('COM_SH404SEF_ADV_TRANSLATE_URL', 'Traduce URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID', 'Adaugă întotdeauna Itemid in URL-ul SEF');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX', 'id meniu');
define('COM_SH404SEF_ALWAYS_INSERT_MENU_TITLE', 'Adaugă întotdeauna titlul meniu-ului');
define('COM_SH404SEF_CACHE_TITLE', 'Management Cache');
define('COM_SH404SEF_CAT_TABLE_SUFFIX', 'Table');
define('COM_SH404SEF_CB_INSERT_NAME', 'Adaugă nume Community Builder');
define('COM_SH404SEF_CB_INSERT_USER_ID', 'Adaugă ID utilizaor');
define('COM_SH404SEF_CB_INSERT_USER_NAME', 'Adaugă nume utilizator');
define('COM_SH404SEF_CB_NAME', 'Nume prestabilit CB');
define('COM_SH404SEF_CB_TITLE', 'Configuraţie Community Builder ');
define('COM_SH404SEF_CB_USE_USER_PSEUDO', 'Adaugă pseudo utilizator');
define('COM_SH404SEF_CONF_TAB_ADVANCED', 'Avansat');
define('COM_SH404SEF_CONF_TAB_BY_COMPONENT', 'După component');
define('COM_SH404SEF_CONF_TAB_MAIN', 'Principal');
define('COM_SH404SEF_CONF_TAB_PLUGINS', 'Plugin-uri');
define('COM_SH404SEF_DEFAULT_MENU_ITEM_NAME', 'Titlu prestabilit meniu');
define('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE','Nu adauga cod');
define('COM_SH404SEF_DO_NOT_OVERRIDE_SEF_EXT', 'Foloseşte plugin-ul componentului sau al sh404sef');
define('COM_SH404SEF_OVERRIDE_SEF_EXT', 'Foloseşte plugin-ul sh404sef dacă este disponibil');
define('COM_SH404SEF_DO_NOT_TRANSLATE_URL','Nu traduce');
define('COM_SH404SEF_ENCODE_URL', 'Encode URL');
define('COM_SH404SEF_FB_INSERT_CATEGORY_ID', 'Adaugă ID categorie');
define('COM_SH404SEF_FB_INSERT_CATEGORY_NAME', 'Adaugă nume categorie');
define('COM_SH404SEF_FB_INSERT_MESSAGE_ID', 'Adaugă ID post');
define('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT', 'Adaugă subiect post');
define('COM_SH404SEF_FB_INSERT_NAME', 'Adaugă nume Kunena');
define('COM_SH404SEF_FB_NAME', 'Nume Kunena prestabilit');
define('COM_SH404SEF_FB_TITLE', 'Configurare Kunena  ');
define('COM_SH404SEF_FILTER', 'Filtru');
define('COM_SH404SEF_FORCE_NON_SEF_HTTPS', 'Forţează non sef daca este HTTPS');
define('COM_SH404SEF_GUESS_HOMEPAGE_ITEMID', 'Ghiceste Itemid in homepage');
define('COM_SH404SEF_IJOOMLA_MAG_NAME', 'Nume magazin prestabilit');
define('COM_SH404SEF_IJOOMLA_MAG_TITLE', 'Configurare iJoomla Magazine');
define('COM_SH404SEF_INSERT_GLOBAL_ITEMID_IF_NONE', 'Adaugă Itemid meniu dacă nu există unul');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Adaugă id articol în URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Adaugă id problema în URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Adaugă id magazine în URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME', 'Adaugă nume magazine în URL');
define('COM_SH404SEF_INSERT_LANGUAGE_CODE', 'Adaugă cod limbă în URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID', 'Adaugă id numeric în URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT', 'Toate categoriile');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST', 'Aplică cărei categorie');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE', 'ID unic');
define('COM_SH404SEF_INSERT_PRODUCT_ID', 'Adaugă ID produs în URL');
define('COM_SH404SEF_INSERT_TITLE_IF_NO_ITEMID', 'Adaugă titlu meniu dacă nu există Itemid');
define('COM_SH404SEF_ITEMID_TITLE', 'Management Itemid');
define('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID', 'Itemid prestabilit pentru pagina Letterman');
define('COM_SH404SEF_LETTERMAN_TITLE', 'Configurare Letterman ');
define('COM_SH404SEF_LIVE_SECURE_SITE', 'SSL URL securizat');
define('COM_SH404SEF_LOG_404_ERRORS', 'Păstrează log-uri pentru erori 404');
define('COM_SH404SEF_MAX_URL_IN_CACHE', 'Marime Cache');
define('COM_SH404SEF_REDIR_404', '404');
define('COM_SH404SEF_REDIR_CUSTOM', 'Personalizat');
define('COM_SH404SEF_REDIR_SEF', 'SEF');
define('COM_SH404SEF_REDIR_TOTAL', 'Total');
define('COM_SH404SEF_REDIRECT_JOOMLA_SEF_TO_SEF', 'Redirecţionare 301 de la JOOMLA SEF la sh404SEF');
define('COM_SH404SEF_REDIRECT_NON_SEF_TO_SEF', 'Redirecţionare 301 de la non-sef la URL sef');
define('COM_SH404SEF_REPLACEMENTS', 'Listă caractere înlocuitoare');
define('COM_SH404SEF_SHOP_NAME', 'Nume magazin prestabilit');
define('COM_SH404SEF_TRANSLATE_URL', 'Traduce URL');
define('COM_SH404SEF_TRANSLATION_TITLE', 'Management Traduceri');
define('COM_SH404SEF_USE_URL_CACHE', 'Activează cache URL');
define('COM_SH404SEF_VM_ADDITIONAL_TEXT', 'Text adiţional');
define('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES', 'Nimic');
define('COM_SH404SEF_VM_INSERT_CATEGORIES', 'Adaugă categorii');
define('COM_SH404SEF_VM_INSERT_CATEGORY_ID', 'Adaugă id categorie în URL');
define('COM_SH404SEF_VM_INSERT_FLYPAGE', 'Adaugă nume afiş');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID', 'Adaugă ID producator');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME', 'Adaugă nume producator în URL');
define('COM_SH404SEF_VM_INSERT_SHOP_NAME', 'Adaugă nume magazin în URL');
define('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES', 'Toate categoriile');
define('COM_SH404SEF_VM_SHOW_LAST_CATEGORY', 'Doar ultima');
define('COM_SH404SEF_VM_TITLE', 'Configurare VirtueMart');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU', 'Foloseşte SKU produs pentru nume');
define('COM_SH404SEF_SHOW_CAT', 'Arată categoria');
define('COM_SH404SEF_SHOW_SECT','Arată secţiunea');
define('COM_SH404SEF_SHOW0','Arată Url-uri SEF');
define('COM_SH404SEF_SHOW1','Arată Log-ul 404');
define('COM_SH404SEF_SHOW2','Arată Redirecţionări Personalizate');
define('COM_SH404SEF_SKIP','sări peste');
define('COM_SH404SEF_SORTBY','Sortează dupa:');
define('COM_SH404SEF_STRANGE','Ceva ciudat a avut loc. Acest lucru nu ar trebui să se întâmple<br />');
define('COM_SH404SEF_STRIP_CHAR','Scoate caracterele');
define('COM_SH404SEF_SUCCESSPURGE','Înregistrările au fost curăţate cu succes');
define('COM_SH404SEF_SUFFIX','Suffx fisier');
define('COM_SH404SEF_SUPPORT','Website<br/>Suport');
define('COM_SH404SEF_SUPPORT_404SEF','Susţineţi-ne');
define('COM_SH404SEF_SUPPORTDESC','Întraţi pe site-ul oficial sh404sef (în fereastră nouă)');
define('COM_SH404SEF_TITLE_ADV','Configurare component avansată');
define('COM_SH404SEF_TITLE_BASIC','Configurare de bază');
define('COM_SH404SEF_TITLE_CONFIG','Configurare sh404SEF');
define('COM_SH404SEF_TITLE_MANAGER','Manager URL sh404SEF');
define('COM_SH404SEF_TITLE_PURGE','Curăţă baza de date a sh404SEF');
define('COM_SH404SEF_TITLE_SUPPORT','Suport sh404SEF');
define('COM_SH404SEF_TT_404PAGE','Selectaţi articolul care va fi arătat ca pagină de eroare în caz că \'Pagina nu a fost gasită\' .<br />Puteţi folosi orice articol \'Fără categorie\'. Cel prestabilit, furnizat de sh404sef, poate fi editat în tab-ul urmator. Îl puteţi găsi si in articolele fără categorie, sub numele de __404__. Poate fi modificat din lista de articole <br/>Aveţi grijă ca acest articol să fie<strong>publicat</strong>!');
define('COM_SH404SEF_TT_ADDFILE','Nume fişier care să fi pus dub un url blank / când nici un fişier nu există.  Folositor pentru roboţii care vizitează site-ul dvs. cautând un fişier anume în acel loc dar primeşte o eroare 404 deoarece nu există acolo.');
define('COM_SH404SEF_TT_ADV','<b>foloseşte manipulantul prestabilit</b><br/>procesează normal, dacă o extensie SEF Advanced este prezentă va fi folosită în loc. <br/><b>nocache</b><br/>nu salvează în baza de date şi crează URL-uri SEF de stil vechi<br/><b>sări peste</b><br/>nu face url-uri SEF pentru acest component<br/>');
define('COM_SH404SEF_TT_ADV4','Optiuni avansate pentru ');
define('COM_SH404SEF_TT_ENABLED','Dacă e setat ca Nu SEF-ul al joomla va fi folosit');
define('COM_SH404SEF_TT_FRIENDTRIM_CHAR','Caracterele de curăţat din URL, separate cu |. Avertizare: dacă modificaţi acesta de la valoare ei prestabilită, asiguraţi-vă că nu-l lăsaţi gol. Cel puţin folosiţi un spaţiu. Datorită unui mic bug în Joomla, acesta nu poate fi lăsat gol.');
define('COM_SH404SEF_TT_LOWER','Convertiţi toate caracterele din URL în litere mici','Toate cu litere mici');
define('COM_SH404SEF_TT_NEWURL','Acest URL trebuie să înceapă cu index.php');
define('COM_SH404SEF_TT_OLDURL','Numai redirecţionarea relativă din rădacina Joomla <i>fară</i> un slash /');
define('COM_SH404SEF_TT_PAGEREP_CHAR','Caracterele folosite pentru a despărţi numerele paginilor de restul URL-ului');
define('COM_SH404SEF_TT_PAGETEXT','Textul adăugat url-ului pentru pagini multiple. Folosiţi %s pentru a insera numărul paginii, prestabilit va fi adăugat la final. Dacă este definit un sufix, va fi adăugat la finalul acestuia.');
define('COM_SH404SEF_TT_REPLACE_CHAR','Caracterul folosit pentru a înlocui caracterele necunoscute în URL');
define('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG', 'Dacă este setat ca <strong>Da</strong>, parametrul id dacă este trecut la componentul com_content va fi interpretat ca Id-ul ediţiei iJoomla magazine.');
define('COM_SH404SEF_TT_ADV_INSERT_ISO', 'Pentru fiecare component instalat, şi dacă site-ul dvs. are mai multe limbi, alegeţi sa insereze sau nu codul ISO al limbii în URL-ul SEF. De exemplu : www.monsite.com/<b>fr</b>/introduction.html. fr este pentru franceză. Acest cod nu va fi inserat limba prestabilită.');
define('COM_SH404SEF_TT_ADV_MANAGE_URL', 'Pentru fiecare component instalat:<br /><b>foloseşte manipulantul prestabilit</b><br/>procesează normal, dacă o extensie SEF Advanced este prezentă acesta va fi folosită. <br/><b>nocache</b><br/>nu salvează în baza de date şi crează URL-uri SEF de stil vechi<br/><b>skip</b><br/>nu face url-uri SEF pentru acest component<br/>');
define('COM_SH404SEF_TT_ADV_OVERRIDE_SEF', 'Unele componente vin cu fişierul sef_ext propriu pentru a fi folosite cu Joomla SEF, OpenSEF or SEF Advanced. Dacă acest parametru este (Treci peste sef_ext), fişierul extensiei nu va fi folosit, şi propriul plugin al sh404SEF va fi folosit în loc (presupunând că există unul în particular pentru acel component). Dacă nu, atunfi fisierul sef_ext al componentului va fi folosit.');
define('COM_SH404SEF_TT_ADV_TRANSLATE_URL', 'Pentru fiecare component instalat, selectaţi dacă URL-ul trebuie tradus. Nici un efect dacă site-ul are doar o limbă.');
define('COM_SH404SEF_TT_ALWAYS_INSERT_ITEMID', 'Dacă e setat ca Da, atunci Itemid-ul non-sef-ului (sau itemid-ul meniului curent dacă niciunul nu se află în URL-ul non-sef) va fi adăugat la URL-ul SEF. Acesta ar trebuie folosit în locul parametrului Inserează întotdeauna titlul meniului, dacă aveţi câteva elemente in meniu cu acelaşi titlu (de exemplu în cazul în care unul este în meniul principal iar celălalt în meniul de sus)');
define('COM_SH404SEF_TT_ALWAYS_INSERT_MENU_TITLE', 'Dacă e setat ca Da, titlul elementului din meniu corespunzător Itemid-ului setat în URL-ul non-sef, sau titlul elementului din meniul curent dacă nu e setat nici un Itemid, va fi inserat in URL-ul SEF.');
define('COM_SH404SEF_TT_CB_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la pagina principală a Community Builder  va fi prefixat la toate SEF URL-urile ale CB');
define('COM_SH404SEF_TT_CB_INSERT_USER_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul utilizatorului va fi prefixat numelui său <strong>când opţiunea anterioară este deasemeni setată ca Da</strong>, în cazul în care doi utilizatori au acelaşi nume.');
define('COM_SH404SEF_TT_CB_INSERT_USER_NAME', 'Dacă e setat ca <strong>Da</strong>, username-ul va fi inserat în URL-urile SEF. <strong>AVERTISMENT</strong>: acest lucru poate duce la creşterea substanţială a mărimii bazei de date, şi vă poate încetini site-ul, dacă aveţi mulţi utilizatori înregistraţi. Dacă e setat ca Nu, id-ul utilizatorului va fi folosit în loc, folosind formatul regular : ..../send-user-email.html?user=245');
define('COM_SH404SEF_TT_CB_NAME', 'Când parametru anterior este setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineţi că acest text va fi invariant, si nu va fi tradus de pildă.');
define('COM_SH404SEF_TT_CB_USE_USER_PSEUDO', 'Dacă e setat ca <strong>Da</strong>, pseudo-ul utilizatorului va fi inserat în URL-ul SEF, dacă aţi activat optiunea de mai sus, în locul numelui său actual.');
define('COM_SH404SEF_TT_DEFAULT_MENU_ITEM_NAME', 'Când parametrul de mai sus este setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineţi că acest text va fi invariant şi de pildă nu va fi tradus');
define('COM_SH404SEF_TT_ENCODE_URL', 'Dacă e setat ca Da, URL-ul va fi  will be codificat pentru a fi compatibil cu limbile care conţin caractere non-latine. URL-ul codificat va arăta ca : mysite.com/%34%56%E8%67%12.....');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul categoriei va fi prefixat numelui său <strong>când opţiunea de mai sus este setată de asemenea ca Da</strong>, în cazul în care două categorii au acelaşi nume.');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME', 'Dacă este setat ca Da, numele categoriei va fi inserat în toate link-urile SEF la un post sau o categorie');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID', 'Dacă e setat ca <strong>Da</strong>, fiecare ID al mesajului va fi prefixat subiectului său <strong>când opţiunea de mai sus este setată de asemenea ca Da</strong>, în cazul în care două mesaje au acelaşi subiect.');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT', 'Dacă e setat ca <strong>Da</strong>, subiectul fiecărui mesaj va fi inserat în URL-ul SEF care duce către mesaje ');
define('COM_SH404SEF_TT_FB_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, tilul elementului din meniu care duce către pagina principală a Kunena va fi prefixat tuturor URL-urilor ale Kunena');
define('COM_SH404SEF_TT_FB_NAME', 'Dacă e setat ca <strong>da<strong>, Numele Kunena name (aşa cum este definit in titlul elementului din meniu) va fi tot timpul prefixat la URL-ul SEF.');
define('COM_SH404SEF_TT_FORCE_NON_SEF_HTTPS', 'Dacă e setat ca Da, URL-ul va fi forţat catre un non sef după schimbarea la modul SSL (HTTPS). Aceasta permite operarea cu unele servere partajate SSL care altfel fac probleme.');
define('COM_SH404SEF_TT_GUESS_HOMEPAGE_ITEMID', 'Dacă e setat ca Da, şi doar în homepage, Itemid-ul URL-urilor componentului com_content vor fi îndepărtate şi înlocuite cu cele pe care sh404SEF le estimează. Acesta este folositor atunci când unele elemente de continut pot fi văzute în frontpage (de exemplu în aspect blog), şi de asemeni în alte pagini din site.');
define('COM_SH404SEF_TT_IJOOMLA_MAG_NAME', 'Când paramentrul de mai sus este setat ca, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineţi că acest text va fi invariant, şi de pildă nu va fi tradus');
define('COM_SH404SEF_TT_INSERT_GLOBAL_ITEMID_IF_NONE', 'Dacă nici un Itemid nu este setat în URL-ul non-sef înainte să fie transformat în unul SEF, şi setaţi acestă opţiune ca adevărată, Itemid-ul curent al elementului din meniu va fi adăugat. Asta va asigura faptul ca atunci când faceţi click pe link va rămâne în aceaşi pagină (ex: aceleaţi module afişate)');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul articolului va fi prefixat fiecărui titlu de articol inserat în URL, ca în : <br /> mysite.com/Joomla-magazine/<strong>56</strong>-Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID', 'Dacă e setat ca <strong>Da</strong>, problema id-ului intern unic fa fi prefixat la numelui fiecărei probleme, pentru a vă asigura că este unic.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul magazinului va fi prefixat fiecărui nume al numelui de magazin inserat în URL, ca în : <br /> mysite.com/<strong>4</strong>-Joomla-magazine/Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME', 'Dacă e setat ca <strong>Da<strong>, numele magazinului  (aşa cum este definit de titlul elementului as defined by magazine menu item title) will allways be prepended to SEF URL');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE', 'Dacă e setat ca <strong>Da</strong>, Codul ISO a limbii din pagininii va fi inserat în URL-ul SEF, cu expecţie doar atunci când limba este cea prestabilită');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID', 'Dacă e setat ca <strong>Da</strong>, un ID numeric va fi adăugat în URL, pentru a facilita includerea în servicii precum Google news. Id-ul va avea formatul: 2007041100000, unde 20070411 este data creării şi 00000 este id-ul unic al articolului. Trebuie să setaţi data creării atunci când articolul este gata de publicare. Vă rugăm să fiţi conştienţi de faptul că nu ar trebui să-l schimbaţi ulterior.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST', 'Id-ul numeric a fi inserat în URL-ul SEF pentru articolele aflate doar în categoriile listate aici.Puteţi selecta categorii multiple ţinând apăsat tasta CTRL după care faceţi click pe numele categoriei.');
define('COM_SH404SEF_TT_INSERT_PRODUCT_ID', 'Dacă e setat ca Da, ID-ul produsului va fi prefixat la numele produsului în URL-ul SEF<br />De exemplu : mysite.com/3-my-very-nice-product.html.<br />Acesta este folositor atunci când nu inseraţi toate nuemele categoriile în URL, şi unele produse din diferite categorii pot avea acelaşi nume.Vă rugăm reţineţi ca acesta nu este SKU-ul produsului, ci mai degrabă id-ul intern la produsului, care este întotdeauna unic.');
define('COM_SH404SEF_TT_INSERT_TITLE_IF_NO_ITEMID', 'Dacă este Nu Itemid-ul este setat în URL-ul non-sef URL înainte să fie transformat într-un URL SEF, şi dacă setaţi această opţiune ca fiind adevărată, tilul emelentului curent din meniu va fi inserat în URL-ul SEF. Acesta ar trebui setat ca adevărat dacă parametru de mai sus este de asemeni setat ca Da, acesta va preveni -2, -3, -... sa fie anexat în URL-ul SEF dacă articolul este vizualizat din locaţii diferite');
define('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID', 'Introduceţi Itemid-ul paginii care să fie inserat în link-urile Letterman links (dezabonare, mesaje de confirmare, ...');
define('COM_SH404SEF_TT_LIVE_SECURE_SITE', 'Setaţi acesta ca <strong>URL-ul de bază complet al site-ului dvs. când site-ul se află în mod SSL</strong>.<br />Este necesar doar dacă folosiţi acces https. Dacă nu este setat, va rămane ca httpS://UrlSiteNormal.<br />Vă rugăm să introduceţi URL-ul complet, fără nici un slash de final. Examplu : <strong>https://www.siteulmeu.com</strong> sau <strong>https://sharedsslserveur.com/contulmeu</strong>.');
define('COM_SH404SEF_TT_LOG_404_ERRORS', 'Dacă e setat ca <strong>Da</strong>, erorile 404 vor fi păstrate în baza de date. Acesta vă poate ajuta să găsiţi erori în link-urile site-ului dvs. De asemenea poate folosi spaţiu necesar în baza de date, deci îl puteţi dezactiva când site-ul dvs. a fost testat complet.');
define('COM_SH404SEF_TT_MAX_URL_IN_CACHE', 'Când cache-ul pentru URL este activat, acest parametru îşi setează marimea sa maximă. Introduceţi numărul maxim de URL-uri care să fie stocat în cache (URL adiţional va fi procesat, dar nu va fi stocat în cache, deci timpul de încărcare va fi mai mare). Aproximativ vorbind, fiecare URL ocupă în jur de 200 bytes (100 pentru URL-ul SEF şi 100 pentru URL-ul non-sef). Deci de exemplu, 5000 de URL-uri vor folosi in jur de 1 MB din memorie.');
define('COM_SH404SEF_TT_REDIRECT_JOOMLA_SEF_TO_SEF', 'Dacă e setat ca <strong>Da</strong>, sh404sef va încerca să redirecţioneze URL-ul SEF standard al JOOMLA către echivalentul său în sh404SEF, dacă există vreunul in baza de date. Dacă nu există, acesta va fi creat din mers, doar dacă nu exista date POST, în cazul cărora nimic nu se întâmplă. Avertizare: acestă facilitate va funcţiona în cele mai multe cazuri, dar poate crea unele redirecţionări greşite pentru unele URL-uri SEF Joomla. Lăsaţi-l dezactivat dacă este posibil.');
define('COM_SH404SEF_TT_REDIRECT_NON_SEF_TO_SEF', 'Dacă e setat ca <strong>Da</strong>, URL non-sef deja existent in baza de date va fi redirecţionat către omologul său SEF, folosind o redireţionare 301 - redirecţionare mutată permanent. Dacă URL-ul SEF nu există, va fi creat, cu excepţie doar în caz că există date transmise prin POST cerute de pagină.');
define('COM_SH404SEF_TT_REPLACEMENTS', 'Caracterele neacceptate în URL, cum ar fi cele non-latine sau cele cu accent, pot fi înlocuite ca în acest tabel de înlocuire. <br />Formatul este xxx | yyy pentru fiecare regulă de înlocuire. xxx este caracterul de înlocuit, unde yyy este noul caracter. <br />Puteţi adăuga multe astfel de reguli, separate prin virgulă (,). Între vechiul caracter şi cel nou, folosiţi un caracter |  <br />Notă de asemenea acel xxx sau yyy pot fi caractere multiple, precum: Å’|oe ');
define('COM_SH404SEF_TT_SHOP_NAME', 'Când parametrul de mai sus este setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Notă, acest text va fi invariant şi de pildă nu va putea fi tradus');
define('COM_SH404SEF_TT_TRANSLATE_URL', 'Dacă este activat şi site-ul are mai multe limbi, elementele URL-ului SEF vor fi traduse în limba vizitatorului, după cum a decis JoomFish. Dacă este dezactivat, URL-ul va fi întotdeauna în limba prestabilită a site-ului. Nu-l folosiţi dacă site-ul nu are mai multe limbi.');
define('COM_SH404SEF_TT_USE_URL_CACHE', 'Dacă este activat, URL-ul SEF va fi scris într-o memorie cache, care va îmbunătăţi timpul de încărcare al paginii în mod semnificativ. În schimb acesta va folosi memoria!');
define('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT', 'Dacă e setat ca <strong>Da</strong>, un text suplimentar va fi adăugat în URL-ul de vizualizare al categoriilor. De exemplu : ..../categoria-A/Vezi-toate-produsele.html VS ..../categoria-A/ .');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORIES', 'Dacă e setat ca <strong>Nimic</strong>, nici un nume de categorie nu va fi inserat în URL ducând la afişarea produsului, ca în : <br /> mysite.com/joomla-cms.html<br />Dacă e setat ca <strong>Doar ultima</strong>, numele categoriei de care produsul aparţine va fi inserată in URL-ul SEF, ca în : <br /> mysite.com/joomla/joomla-cms.html<br />Dacă e setat ca <strong>Toate categoriile</strong>, numele tuturor categoriilor din care produsul face parte vor fi adăugate, ca în : <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID', 'Dacă e setat ca Da, ID-ul categoriei va fi prefixat fiecarui nume de categorie inserat în URL ducând la un produs, ca în : <br /> mysite.com/1-software/4-cms/1-joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_FLYPAGE', 'Dacă e setat ca Da, numele afiş-ului va fi inserat în URL ducând la detaliile produsului. Poate fi dezactivat daca folosiţi doar un afiş.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID', 'Dacă e setat ca Da, ID-ul producătorului va fi prefixat la numele producătorului în URL-ul SEF <br />De exemplu : mysite.com/6-nume-producator/3-produsul-menu-draguţ.html.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME', 'Dacă e setat ca Da, numele producătorului, dacă există vreunul, va fi inserat în URL-ul SEF ducând la produs.<br />De exemplu : mysite.com/nume-producător/nume-produs.html');
define('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME', 'Dacă e setat ca <strong>da</strong>, numele magazinului (aşa cum este definit în titlul elementului din meniu) va fi întotdeauna prefixat URL-ului SEF');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU', 'Dacă e setat ca Da, SKU-ul produsului, codul de produs pe care-l introduceţi la fiecare produs, va fi folosit în locul numelui complet al produsului.');
define('COM_SH404SEF_TT_SHOW_CAT','Setaţi ca da pentru a include numele categoriei în URL');
define('COM_SH404SEF_TT_SHOW_SECT','Setaţi ca da pentru a include numele secţiunii în URL');
define('COM_SH404SEF_TT_STRIP_CHAR','Caracterele curăţate din URL, separate prin |');
define('COM_SH404SEF_TT_SUFFIX','Extensia folosită pentru \'fişiere\'. Lăsaţi gol pentru a dezactiva. O valoare comună aici este \'html\'.');
define('COM_SH404SEF_TT_USE_ALIAS','Setaţi ca da pentru a folosi alias-ul titlului în locul titlului în URL');
define('COM_SH404SEF_UNWRITEABLE',' <b><font color="red">Nu poate fi scris</font></b>');
define('COM_SH404SEF_UPLOAD_OK','Fişierul a fost încărcat cu succes');
define('COM_SH404SEF_URL','Url');
define('COM_SH404SEF_URLEXIST','Acest URL există deja în baza de date!');
define('COM_SH404SEF_USE_ALIAS','Foloseşte Alias Titlu');
define('COM_SH404SEF_USE_DEFAULT','(foloseşte manipulantul prestabilit)');
define('COM_SH404SEF_USING_DEFAULT',' <b><font color="red">Folosind valorile prestabilite</font></b>');
define('COM_SH404SEF_VIEW404','Vezi/Editează<br/>Loguri 404');
define('COM_SH404SEF_VIEW404DESC','Această pagină vă va arăta o listă de cereri făcute către site-ul dvs. de utilizatori ce au dus către o pagină care nu există. Veţi avea posibilitatea să curăţaţi aceste înregistrări - după ce verificaţi cu atenţie dacă au rezultat dintr-o scriere greşită sau posibil din link-uri defecte în site-ul dvs.');
define('COM_SH404SEF_VIEWCUSTOM','Vezi/Editează<br/>Redirecţionări Personalizate');
define('COM_SH404SEF_VIEWCUSTOMDESC','Vezi/Editează<br/>Redirecţionări Personalizate');
define('COM_SH404SEF_VIEWMODE','ModVizualizare:');
define('COM_SH404SEF_VIEWURL','Manager URL');
define('COM_SH404SEF_VIEWURLDESC','Acestă pagină vă va arăta o listă cu toate URL-uril, cu toate detaliile despre ele. Aici trebuie sa mergeţi pentru a personaliza sau a şterge URL-uri SEF. De asemeni de acolo veţi putea să setaţi titlurile paginilor si tag-urile meta, creaţi alias-uri, manageriaţi duplicari pentru url-uri non-sef, şi curăţaţi unele sau toate url-urile din baza de date');
define('COM_SH404SEF_WARNDELETE','AVERTISMENT!!!  Sunteţi pe cale să ştergeţi ');
define('COM_SH404SEF_WRITE_ERROR','Eroare la scrierea configurării');
define('COM_SH404SEF_WRITE_FAILED','Fişierul încărcat nu poate fi scris în directorul tmp');
define('COM_SH404SEF_WRITEABLE',' <b><font color="green">Poate fi scris</font></b>');

// V 1.2.4.s
define('COM_SH404SEF_DOCMAN_TITLE', 'Configurare DOCMan');
define('COM_SH404SEF_DOCMAN_INSERT_NAME', 'Inserează nume DOCMan');
define('COM_SH404SEF_TT_DOCMAN_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la pagina principala a DOCMan va fi prefixat la toate URL-urile SEF ale DOCMan');
define('COM_SH404SEF_DOCMAN_NAME', 'Nume DOCMan prestabilit');
define('COM_SH404SEF_TT_DOCMAN_NAME', 'Când parametrul anterior va fi setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineţi ca acest text va fi invariabil şi de pildă nu va putea fi tradus');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_ID', 'Inserează ID documenet');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul documentului va fi prefixat la numele documentului, care este necesar în caz că unele documente au nume identice.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME', 'Inserează nume document');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME', 'Dacă e setat ca <strong>Da</strong>, numele documentului va fi inserat în toate URL-urile SEF care duc la o acţiune asupra acestui document');
define('COM_SH404SEF_MYBLOG_TITLE', 'Configurare MyBlog');
define('COM_SH404SEF_MYBLOG_INSERT_NAME', 'Inserează nume MyBlog');
define('COM_SH404SEF_TT_MYBLOG_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la pagina principală a MyBlog va fi prefixat la toate URL-urile SEF ale MyBlog');
define('COM_SH404SEF_MYBLOG_NAME', 'Nume Myblog prestabilit');
define('COM_SH404SEF_TT_MYBLOG_NAME', 'Când parametrul anterior este setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineţi ca acest text va fi invariabil şi de pildă nu va putea fi tradus.');
define('COM_SH404SEF_MYBLOG_INSERT_POST_ID', 'Inserează ID mesaj');
define('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul intern al mesajului va fi prefixat la titlul mesajului, necesar în caz că unele mesaje au titluri identice.');
define('COM_SH404SEF_MYBLOG_INSERT_TAG_ID', 'Inserează id tag');
define('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul intern al tag-ului va fi prefixat la numele tag-ului, necesar în caz că unele tag-uri sunt identice, sau interferează cu numele unei categorii.');
define('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID', 'Inserează id blogger');
define('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul intern al blogger-ului va fi prefixat la numele blogger-ului, necesar in caz că unuii bloggeri au acelaşi nume.');
define('COM_SH404SEF_RW_MODE_NORMAL', 'cu .htaccess (mod_rewrite)');
define('COM_SH404SEF_RW_MODE_INDEXPHP', 'fară .htaccess (index.php)');
define('COM_SH404SEF_RW_MODE_INDEXPHP2', 'fară .htaccess (index.php?)');
define('COM_SH404SEF_SELECT_REWRITE_MODE', 'Mod rescriere');
define('COM_SH404SEF_TT_SELECT_REWRITE_MODE', 'Selectaţi un mod de rescriere pentru sh404SEF.<br /><strong>cu .htaccess (mod_rewrite)</strong><br />Mod prestabilit : trebuie să aveţi un fişier .htacces, configurat corect pentru a se potrivi configurării server-ului dvs.<br /><strong>fără .htaccess (index.php)</strong><br />Nu aveţi nevoie de un fişier .htaccess. Acest mod foloseşte funcţia PathInfo a server-elor Apache. URL-urile vor avea adaugat un /index.php/ la început. Nu este imposibil ca server-ele IIS să accepte aceste URL-uri<br /><strong>fără .htaccess (index.php?)</strong><br /><strong>Beneficiu redus :</strong>Nu aveţi nevoie de un fişier .htaccess. Acest mod este identic cu cel anterior, doar ca va fi folosit /index.php?/ în loc de /index.php/. Din nou, server-ele IIS pot accepta aceste URL-uri<br />');
define('COM_SH404SEF_RECORD_DUPLICATES', 'Înregistrează URL duplicat');
define('COM_SH404SEF_TT_RECORD_DUPLICATES', 'Dacă e setat ca <strong>Da</strong>, sh404SEF va înregistra in baza de date toate URL-urile non sef care au acelaşi url SEF. Acesta vă permite să alegeţi pe cel care-l preferaţi, folosind funcţia Manager Duplicări în lista cu URL-uri SEF afişată.');
define('COM_SH404SEF_META_TITLE', 'Titlu Pagină');
define('COM_SH404SEF_TT_META_TITLE', 'Scrieţi textul care să fie inserat în tag-ul <strong>META Title</strong> pentru url-ul selectat.');
define('COM_SH404SEF_META_DESC', 'Tag-ul Description');
define('COM_SH404SEF_TT_META_DESC', 'Scrieţi textul care să fie inserat în tag-ul the <strong>META Description</strong> pentru url-ul selectat.');
define('COM_SH404SEF_META_KEYWORDS', 'Tag-ul Keywords');
define('COM_SH404SEF_TT_META_KEYWORDS', 'Scrieţi textul care să fie inserat în tag-ul <strong>META keywords</strong> pentru url-ul selectat. Toate cuvintele sau grupurile de cuvinte trebuie să fie despărţite prin virgulă.');
define('COM_SH404SEF_META_ROBOTS', 'Tag-ul Robots');
define('COM_SH404SEF_TT_META_ROBOTS', 'Scrieţi textul care să fie inserat în tag-ul <strong>META Robots</strong> pentru url-ul selectat. Acest tag le spune motoarelor de căutare dacă trebuie să urmeze link-urile din această pagină, si ce să facă cu conţinutul acestei pagini curente. Valori comune :<br /><strong>INDEX,FOLLOW</strong> : index-ează conţinutul paginii curente, si urmează link-urile găsite pe pagină<br /><strong>INDEX,NO FOLLOW</strong> : index-ează conţinutul paginii curente, dar să nu urmeze link-urile găsite în această pagină<br /><strong>NO INDEX, NO FOLLOW</strong> : să nu index-eze conţinutul paginii curente, şi să nu urmeze link-urile găsite pe această pagină<br />');
define('COM_SH404SEF_META_LANG', 'Tag-ul Language');
define('COM_SH404SEF_TT_META_LANG', 'Scrieţi textul care să fie inserat în tag-ul <strong>META http-equiv= Content-Language </strong> pentru url-ul selectat. ');
define('COM_SH404SEF_CONF_TAB_META', 'Meta/SEO');
define('COM_SH404SEF_CONF_META_DOC', 'sh404SEF are câteva plugin-uri care creează <strong>automat</strong> tag-urile titlul paginii si descrierea pentru unele componente. Mai multe plugin-uri pot fi create de alţi dezvoltatori, atunci când crearea automată a tag-urilor meta este posibilă. Dacă nici un plugin nu este furnizat pentru anumite extensii, cel mai bine  ar fi să personalizaţi manual tag-urile, sau să le lăsaţi goale.<br>');
define('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR', 'Sterge tag-ul Joomla Generator');
define('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR', 'Dacă e setat ca <strong>Da</strong>, meta tag-ul Generator = Joomla va fi şters din toate paginile.');
define('COM_SH404SEF_PUT_H1_TAG', 'Inserează tag-uri h1');
define('COM_SH404SEF_TT_PUT_H1_TAG', 'Dacă e setat ca <strong>Da</strong>, titlurile conţinutului for fi plasate in tag-uri h1. Normal aceste titluri sunt plasate de Joomla într-o clasăCSS al cărui nume începe cu <strong>contentheading</strong>.');
define('COM_SH404SEF_META_MANAGEMENT_ACTIVATED', 'Activează management SEO');
define('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED', 'Dacă e setat ca <strong>Da</strong>, Tag-urile META Title, Description, Keywords, Robots şi Language for fi manageriate de sh404SEF. În caz contrar, valorile originale produse de Joomla şi / sau alte componente vor fi lăsate neatinse. ');
define('COM_SH404SEF_TITLE_META_MANAGEMENT', 'Management SEO');
define('COM_SH404SEF_META_EDIT', 'Modifică tag-uri');
define('COM_SH404SEF_META_ADD', 'Adaugă tag-uri');
define('COM_SH404SEF_META_TAGS', 'Manager Titlu şi meta');
define('COM_SH404SEF_META_TAGS_DESC', 'Creează/modifică tag-uri Meta');
define('COM_SH404SEF_PURGE_META_DESC', 'Curăţă tag-uri meta');
define('COM_SH404SEF_PURGE_META', 'Șterge META');
define('COM_SH404SEF_IMPORT_EXPORT_META', 'Importă/exportă META');
define('COM_SH404SEF_NEW_META', 'META nou');
define('COM_SH404SEF_NEWURL_META', 'Url Non SEF');
define('COM_SH404SEF_TT_NEWURL_META', 'Introduceţi URL-ul non SEF pentru care doriţi sa setaţi tag-urile Meta. AVERTISMENT: trebuie să înceapă cu <strong>index.php</strong>!');
define('COM_SH404SEF_BAD_META', 'Vă rugăm să verificaţi datele dvs.: unele date introduse nu sunt valide.');
define('COM_SH404SEF_META_TITLE_PURGE', 'Șterge tag-uri meta');
define('COM_SH404SEF_META_SUCCESS_PURGE', 'Tag-uri meta şterse');
define('COM_SH404SEF_IMPORT_META', 'Importă tag-uri Meta');
define('COM_SH404SEF_EXPORT_META', 'Exportă tag-uri Meta');
define('COM_SH404SEF_IMPORT_META_OK', 'Tag-urile Meta au fost importate cu succes');
define('COM_SH404SEF_SELECT_ONE_URL', 'Vă rugăm selectaţi un (şi numai unul) URL.');
define('COM_SH404SEF_MANAGE_DUPLICATES', 'Management URL pentru : ');
define('COM_SH404SEF_MANAGE_DUPLICATES_RANK', 'Rank');
define('COM_SH404SEF_MANAGE_DUPLICATES_BUTTON', 'Url Duplicat');
define('COM_SH404SEF_MANAGE_MAKE_MAIN_URL', 'URL Principal');
define('COM_SH404SEF_BAD_DUPLICATES_DATA', 'Eroare : date URL invalide');
define('COM_SH404SEF_BAD_DUPLICATES_NOTHING_TO_DO', 'Acest URL este deja URL-ul principal');
define('COM_SH404SEF_MAKE_MAIN_URL_OK', 'Operaţiunea finalizată cu succes');
define('COM_SH404SEF_MAKE_MAIN_URL_ERROR', 'A avut loc o eroare, operaţiunea nu a reuşit');
define('COM_SH404SEF_CONTENT_TITLE', 'Configurare conţinut');
define('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME', 'Inserează nume tabelă conţinut');
define('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME', 'Dacaă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la o tabelă cu articole (categorie sau secţiune) va fi prefixat URL-ului său SEF. Acesta permite afişarea separată în afişări tip blog.');
define('COM_SH404SEF_CONTENT_TABLE_NAME', 'Nume prestabilit al vizualizării tabelei');
define('COM_SH404SEF_TT_CONTENT_TABLE_NAME', 'Când parametrul anterior este setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineţi ca acest text este invariabil şi de pildă nu poate fi tradus.');
define('COM_SH404SEF_REDIRECT_WWW', 'Redirecţionare 301 www/non-www');
define('COM_SH404SEF_TT_REDIRECT_WWW', 'Dacă e setat ca Da, sh404SEF va face o redirecţionare 301 dacă site-ul este accesat fără www dacă URL-ul site-ului începe cu www, sau dacă site-ul este accesat cu începând cu www în timp ce url-ul principal nu are www. Va preveni penalităţile pentru conţinut duplicat, şi unele probleme depinzând de configurarea server-ul dvs. Apache, cât şi problemele cu (Editoarele WYSYWIG) ale Joomla');
define('COM_SH404SEF_INSERT_PRODUCT_NAME', 'Inserează nume produs');
define('COM_SH404SEF_TT_INSERT_PRODUCT_NAME', 'Dacă e setat ca Da, numele produsului va fi inserat în URL');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S', 'Inserează cod produs');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S', 'Dacă e setat ca Da, cod-ul produsului (denumit SKU în VirtueMart) va fi inserat în URL.');

// V 1.2.4.t
define('COM_SH404SEF_DOCMAN_INSERT_CAT_ID', 'Inserează ID categorie');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID', 'Daca e setat ca <strong>Da</strong>, ID-ul categoriei va fi prefixat numelui său <strong>atunci când opţiunea anterioară este setată de asemenea ca Da</strong>, în cazul în care două categorii au acelaşi nume.');
define('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES', 'Inserează nume categorie');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES', 'Dacă e setat ca <strong>Nimic</strong>, nici un nume de categorie nu va fi inserat în URL, ca în : <br /> mysite.com/joomla-cms.html<br />Dacă e setat ca <strong>Numai ultima</strong>, numele categoriei va fi inserat în URL-ul SEF, ca în : <br /> mysite.com/joomla/joomla-cms.html<br />Daca e setat ca <strong>Toate categoriile</strong>, numele tuturor categoriilor va fi adăugat, ca în : <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_FORCED_HOMEPAGE', 'URL Home page');
define('COM_SH404SEF_TT_FORCED_HOMEPAGE', 'Puteţi adăuga aici un URL pentru home page forţat. Folositor dacă aveţi setat o &rsquo;pagină splash&rsquo; de obicei un fişier index.html, care este afişat când vizualizaţi www.mysite.com. If so, type the following URL: www.mysite.com/index.php (no trailing /), so that the Joomla site is displayed when the Home link of main menu or pathway is clicked');
define('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME', 'Inserează nume vizualizare blog');
define('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la un blog al articolelor (categorie sau secţiune) va fi prefixat URL-ul său SEF. Acesta permite afişarea separată în afişări tip blog.');
define('COM_SH404SEF_CONTENT_BLOG_NAME', 'Nume vizualizare blog prestabilit');
define('COM_SH404SEF_TT_CONTENT_BLOG_NAME', 'Când parametrul anterior este setat ca Da, puteţi suprascrie textul inserat în URL-ul SEF aici. Reţineti ca acest text este invariabil şi de pildă nu poate fi tradus.');
define('COM_SH404SEF_MTREE_TITLE', 'Configurare Mosets Tree');
define('COM_SH404SEF_MTREE_INSERT_NAME', 'Inserează nume MTree');
define('COM_SH404SEF_TT_MTREE_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la Mosets Tree va fi prefixat URL-ului său SEF.');
define('COM_SH404SEF_MTREE_NAME', 'Nume prestabilit MTree');
define('COM_SH404SEF_MTREE_INSERT_LISTING_ID', 'Inserează ID listare');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID', 'Dacă e setat ca <strong>Da</strong>, un ID al listării va fi prefixat numelui său, în cazul în care două listări au acelasi nume.');
define('COM_SH404SEF_MTREE_PREPEND_LISTING_ID', 'Prefixează ID la nume');
define('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID', 'Dacă e setat ca <strong>Da</strong>, când opţiunea anterioară este setată şi ea ca Da, ID-ul va fi <strong>prefixat</strong> la numele listării. Dacă e setat ca Nu, va fi <strong>sufixat</strong> numelui.');
define('COM_SH404SEF_MTREE_INSERT_LISTING_NAME', 'Inserează nume listare');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME', 'Dacă e setat ca <strong>Da</strong>, numele listării va fi adăugat în toate URL-urile care duc la o acţiune asuprea acestei listări.');

define('COM_SH404SEF_IJOOMLA_NEWSP_TITLE', 'Configurare News Portal');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME', 'Inserează nume News Portal');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la iJoomla News Portal va fi prefixat url-ului său SEF.');
define('COM_SH404SEF_IJOOMLA_NEWSP_NAME', 'Nume News Portal prestabilit');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Inserează ID categorie');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul categoriei va fi prefixat, în caz că două listări au acelaşi nume.');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Inserează ID secţiune');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul secţiunii va fi prefixat numelui său, în caz că două listări au acelaşi nume.');
define('COM_SH404SEF_REMO_TITLE', 'Configurare Remository');
define('COM_SH404SEF_REMO_INSERT_NAME', 'Inserează nume Remository');
define('COM_SH404SEF_TT_REMO_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la Remository va fi prefixat url-ului său SEF.');
define('COM_SH404SEF_REMO_NAME', 'Nume Remository predefinit');
define('COM_SH404SEF_CB_SHORT_USER_URL', 'Url scurt către profil utilizator');
define('COM_SH404SEF_TT_CB_SHORT_USER_URL', 'Dacă e setat ca <strong>Da</strong>, utilizatorul va putea să-şi acceseze profilul printr-ul URL scurt similar cu www.mysite.com/username. Înainte de a activa acestă opţiune, verificaţi să nu aveţi conflicte cu alte URL-uri deja existente pe site.');
define('COM_SH404SEF_NEW_HOME_META', 'Meta Home page');
define('COM_SH404SEF_CONF_ERASE_HOME_META', 'Sunteţi sigur că doriţi să ştergeţi titlul paginii home page şi tag-urile meta ?');
define('COM_SH404SEF_UPGRADE_TITLE', 'Configurare actualizare');
define('COM_SH404SEF_UPGRADE_KEEP_URL', 'Păstraţi URL-urile automate');
define('COM_SH404SEF_TT_UPGRADE_KEEP_URL', 'Dacă e setat ca <strong>Da</strong>, URL-urile SEF generate automat de sh404sef vor fi salvate şi păstrate atunci când dezinstalaţi componentul. În acest fel veţi găsi url-urile la locul lor după ce aţi instalat versiunea nouă, fără să fie nevoie de alte acţiuni.');
define('COM_SH404SEF_UPGRADE_KEEP_CUSTOM', 'Păstraţi URL-urile personalizate, aliases-urile, shURL-urile');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CUSTOM', 'Dacă e setat ca <strong>Da</strong>, URL-urile SEF personalizate vor fi salvae şi păstrate atunci când dezinstalaţi componentul . În acest fel le veţi găsi la locul lor după ce aţi instalat versiunea nouă, fără să fie nevoie de alte acţiuni.');
define('COM_SH404SEF_UPGRADE_KEEP_META', 'Păstraţi Titlurile şi Meta');
define('COM_SH404SEF_TT_UPGRADE_KEEP_META', 'Dacă e setat ca <strong>Da</strong>, titlurile şi meta tag-urile personalizate vor fi salvate şi păstrate atunci când dezinstalaţi componentul. În acest fel le veţi găsi la locul lor după ce aţi instalat versiunea nouă, fără să fie nevoie de alte acţiuni.');
define('COM_SH404SEF_UPGRADE_KEEP_MODULES', 'Păstraţi parametrii module');
define('COM_SH404SEF_TT_UPGRADE_KEEP_MODULES', 'Dacă e setat ca <strong>Da</strong>, parametrii actuali de publicare cum ar fi poziţia, ordinea, titlurile, ale modulelor shJoomfish şi shCustomtags vor fi salvate şi păstrate când dezinstalaţi componentul. În acest fel le veţi găsi la locul lor după ce aţi instalat versiunea nouă, fără să fie nevoie de alte acţiuni.');
define('COM_SH404SEF_IMPORT_OPEN_SEF','Importă redirecţionări de la OpenSEF');
define('COM_SH404SEF_IMPORT_ALL','Importă redirecţionări');
define('COM_SH404SEF_EXPORT_ALL','Exportă redirecţionări');
define('COM_SH404SEF_IMPORT_EXPORT_CUSTOM','Importă/Exportă redirecţionări personalizate');
define('COM_SH404SEF_DUPLICATE_NOT_ALLOWED', 'Acest URL există deja, deoarece nu aţi permis URL-urile duplicate');
define('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE', 'Activează titluri inteligente pentru articolele cu pagini multiple');
define('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE', 'Dacă e setat ca Da, pentru articolele cu pagini multiple (cele cu un conţinut still tabel), sh404SEF va folosi titlurile paginilor inserate folosind comanda mospagebreak : {mospagebreak title=Tilul_Paginii_următoare şi heading=Titlul_Paginii_anterioare}, în loc la numărul de pagină<br />De exemplu, un URL SEF asemănător cu www.mysite.com/documentatie-utilizator/<strong>Pagina-2</strong>.html acum va fi înlocuit cu www.mysite.com/documentatie-utilizator/<strong>Invata-sa-folosesti-sh404SEF</strong>.html.');

// v x
define('COM_SH404SEF_UPGRADE_KEEP_CONFIG', 'Păstrează configurarea');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CONFIG', 'Dacă e setat ca Da, toţi parametrii configurării vor fi salvaţi si păstraţi atunci când dezinstalaţi componentul. În acest fel îi veţi găsi la locul lor după ce aţi instalat versiunea nouă, fără să fie nevoie de alte acţiuni..');
define('COM_SH404SEF_CONF_TAB_SECURITY', 'Securitate');
define('COM_SH404SEF_SECURITY_TITLE', 'Configurare Securitate');
define('COM_SH404SEF_HONEYPOT_TITLE', 'Configurare Project Honey Pot');
define('COM_SH404SEF_CONF_HONEYPOT_DOC', 'Project Honey Pot este o iniţiativă care vizează protejarea site-uri web de la roboţi de spam. Acesta oferă o bază de date pentru a verifica o adresa IP vizitator împotriva roboţilor cunoscuţi. Folosind această bază de date necesită o cheie de acces (gratuită), va trebui să o obţineţi <a href="http://www.projecthoneypot.org/httpbl_configure.php">de pe site-ul proiectului</a><br />(Trebuie să creaţi un cont înainte de a solicita cheia de acces - acest lucru este gratuit de asemeni). Dacă se poate, să consideraţi a ajuta proiectul prin înfiinţarea de `capcane` în spaţiu dumneavoastră web, pentru a ajuta la identificarea roboţilor de spam.');
define('COM_SH404SEF_ACTIVATE_SECURITY', 'Activează funcţii securitate');
define('COM_SH404SEF_TT_ACTIVATE_SECURITY', 'Dacă e setat ca Da, sh404SEF va face nişte verificări de bază privind URL-urile cerute site-ului dvs., în scopul de a se proteja împotriva atacurilor comune.');
define('COM_SH404SEF_LOG_ATTACKS', 'Salvează log atacuri');
define('COM_SH404SEF_TT_LOG_ATTACKS', 'Dacă e setat ca Da, atacurile idenficate vor fi salvate într-un fişier text, incluzând adresa IP address a atacatorului şi cererea făcută.<br />Există un fişier de log-uri pe lună. Ele sunt localizate în directorul <rădăcină site>/administrator/com_sh404sef/logs. Le puteţi descărca folsind FTP-ul, sau folosiţi utilitarele Joomla precum Joomla Explorer pentru a le vizualiza. Ele sunt fişiere text în format TAB, astfel încât software-ul de foi de calcul ar trebui să-l poată deschide apoi cu usurinţă, probabil cel mai simplu mod pentru a le vizualiza.');	            
define('COM_SH404SEF_CHECK_HONEY_POT', 'Foloseşte Project Honey Pot');
define('COM_SH404SEF_TT_CHECK_HONEY_POT', 'Dacă e setat ca Da, adresele de IP ale vizitatorilor vor fi verificate în baza de date a Project Hoeny Pot, folosind serviciul lor HTTP:BL. Acesta este gratuit, dar necesită obţinerea unei chei de acces de pe site-ul lor.');
define('COM_SH404SEF_HONEYPOT_KEY', 'Cheie de acces Project Honey Pot');
define('COM_SH404SEF_TT_HONEYPOT_KEY', 'Dacă opţiune Foloseşte Project Honey Pot este activată, trebuie să obţineţi o cheie de acces de la from P.H.P. Scrieţi cheia de acces primită aici. Este un şir de 12 caractere.');	             
define('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT', 'Text alternativ');
define('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT', 'Dacă adresa de IP a unui vizitator a fost semnalată ca fiind suspicioasă de Project Honey Pot, accesul pe site va fi restricţionat (Rezltat cod 403). <br />Cu toate acestea, în caz de detectare falsă, textul tastat aici va fi afişat vizitatorului, cu un link unde trebuie să dea click pentru a putea accesa site-ul. Numai un om poate citi şi înţelege un astfel de text, şi roboţii nu pot accesa link-ul. <br />Puteţi ajusta acest text cum vă place.' );	             
define('COM_SH404SEF_SMELLYPOT_TEXT', 'Text capcană robot');
define('COM_SH404SEF_TT_SMELLYPOT_TEXT', 'Când un robot de spam a fost identificat prin intermediul Project Honey Pot, şi accesul a fost restricţionat, un link se adaugă la partea de jos a ecranului, pentru ca P.H.P să înregistreze acţiunea robotului. Un mesaj este, de asemenea, adaugă pentru a preveni persoane reale să facă clic pe link, în cazul în care acestea au fost în mod eronat semnalizat. ');
define('COM_SH404SEF_ONLY_NUM_VARS', 'Parametrii numerici');
define('COM_SH404SEF_TT_ONLY_NUM_VARS', 'Numele parametrilor puse în această listă vor fi verificate pentru a fi doar numerice: cifre 0-9 numai. Introduceţi un parametru pe linie.');
define('COM_SH404SEF_ONLY_ALPHA_NUM_VARS', 'Parametrii alfa-numerici');
define('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS', 'Numele parametrilor puse în această listă vor fi verificate pentru a fi doar alfa-numerice: cifre 0-9, şi literele de la A la Z. Introduceţi un parametru pe linie.');
define('COM_SH404SEF_NO_PROTOCOL_VARS', 'Verifică  parametrii Check hyperlink-uri în parameterii');
define('COM_SH404SEF_TT_NO_PROTOCOL_VARS', 'Numele parametrilor puse în această listă vor fi verificate pentru a nu avea hyperlink-uri în ele, începând cu http://, https://, ftp:// ');
define('COM_SH404SEF_IP_WHITE_LIST', 'Lista albă IP-uri');
define('COM_SH404SEF_TT_IP_WHITE_LIST', 'Orice cerere provenind de la o adresă IP din această listă va fi <stong>acceptată</strong>, presupunând că URL-ul trece verificările mai sus menţionate. Introduceţi un IP pe linie.<br />Puteţi folosi * ca un wildcard, ca în : 192.168.0.*. Aceasta va cuprinde IP-urile de la 192.168.0.0 la 192.168.0.255.');
define('COM_SH404SEF_IP_BLACK_LIST', 'Lista neagră IP-uri');
define('COM_SH404SEF_TT_IP_BLACK_LIST', 'Orice cerere provenind de la o adresă IP din această listă va fi <strong>blocată</strong>, presupunând că URL-ul trece verificările mai sus menţionate. Introduceţi un IP pe linie.<br />Puteţi folosi * ca un wildcard, ca în : 192.168.0.*. Aceasta va cuprinde IP-urile de la 192.168.0.0 la 192.168.0.255.');
define('COM_SH404SEF_UAGENT_WHITE_LIST', 'Lista albă UserAgent');
define('COM_SH404SEF_TT_UAGENT_WHITE_LIST', 'Orice cerere făcută cu un şir de UserAgent din această listă va fi <stong>acceptat</strong>, presupunând că URL-ul trece verificările mai sus menţionate. Introduceţi câte un nume de UserAgent pe linie.');
define('COM_SH404SEF_UAGENT_BLACK_LIST', 'Lista neagră UserAgent');
define('COM_SH404SEF_TT_UAGENT_BLACK_LIST', 'Orice cerere făcută cu un şir de UserAgent din această listă va fi <strong>blocată</strong>, presupunând că URL-ul trece verificările mai sus menţionate. Introduceţi câte un nume de UserAgent pe linie.');
define('COM_SH404SEF_MONTHS_TO_KEEP_LOGS', 'Câte luni se păstrează log-urile de securitate');
define('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS', 'Daca păstrarea log-urilor de atacuri este activată, puteţi seta aici numărul de luni cât vor fi păstrate aceste fişiere cu log-uri. De exemplu, setând acestă opţiune la 1 înseamnă ca luna curentă PLUS luna dinainte vor fi păstrate. Fişierele log ale lunilor anterioare for fi şterse.');
define('COM_SH404SEF_ANTIFLOOD_TITLE', 'Configurare Anti-flood');
define('COM_SH404SEF_ACTIVATE_ANTIFLOOD', 'Activateză anti-flood');
define('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD', 'Dacă e setat ca Da, sh404SEF va verifica care orice adresă IP să nu facă prea multe cereri de pagină pe site. Făcând multe cereri, una după alta un pirat poate face site-ul dvs. de neutilizat şi doar la supraîncărcarea server-ului.');
define('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST', 'Doar dacă există form-uri POST date');
define('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST', 'Dacă e setat ca Da, acest control va avea loc doar dacă există date POST în cererea paginii. Acesta se întâmplă de obicei în cazul paginilor form, astfel încât se poate limita anti-flood control numai la form-uri pentru a vă proteja împotriva roboţilor de spam.');
define('COM_SH404SEF_ANTIFLOOD_PERIOD', 'Control Anti-flood');
define('COM_SH404SEF_TT_ANTIFLOOD_PERIOD', 'Durata (în secunde) over which the number of requests from the same IP address will controled');
define('COM_SH404SEF_ANTIFLOOD_COUNT', 'Număr maxim de cereri');
define('COM_SH404SEF_TT_ANTIFLOOD_COUNT', 'Numărul de cereri care va declanşa blocarea pagini pentru adresa IP care încalcă prevederile legale. De exemplu, introducând Perioada = 10 şi numărul de cereri = 4 va bloca accesul (returnează un cod 403, şi aproape pagina goală) de îndată ce cele 4 cereri au fost primite de la o anumită adresă IP în mai puţin de 10 secunde. Desigur, accesul va fi blocat numai pentru această adresă IP, nu şi pentru alţi vizitatori ai site-ului.');
define('COM_SH404SEF_CONF_TAB_LANGUAGES', 'Limbi');
define('COM_SH404SEF_DEFAULT', 'Predefinit');
define('COM_SH404SEF_YES', 'Da');
define('COM_SH404SEF_NO', 'Nu');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_PER_LANG', 'Dacă e setat ca Da, codul limbii va fi inserat in url pentru <strong>această limbă</strong>. Dacă e setat ca nu, codul limbii nu va fi inserat niciodată. Dacă e setat ca Predefinit, Codul de limbă va fi introdus pentru toate limbile, dar limba predefinită a site-ului.');
define('COM_SH404SEF_TT_TRANSLATE_URL_PER_LANG', 'Dacă e setat ca Da, şi site-ul dvs. are mai multi limbi, url-ul dvs. va fi tradus pentru URL <strong>în această limbă</strong>, ca în setările JoomFish. Dacă e setat ca nu, URL-ul nu va fi tradus niciodată. Dacă e setat ca Predefinit, vor fi traduse de asemenea. Nu are nici un efect pentru site-urile cu o singură limbă.');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_GEN', 'Dacă e setat ca Da, un cod de limbă va fi inserat in URL de sh404SEF. Puteţi avea de asemenea una pentur fiecare limbă (vezi mai jos).');
define('COM_SH404SEF_TT_TRANSLATE_URL_GEN', 'Dacă e setat ca Da, şi site-ul dvs. are mai multe limbi, URL-ul va fi tradus în limba vizitatorului, ca în setările Joomfish. În caz contrar, URL-ul va rămâne în limba prestabilită site-ului. Puteţi avea, de asemenea, una pentru fiecare limbă (vezi mai jos)');
define('COM_SH404SEF_ADV_COMP_DEFAULT_STRING', 'Nume prestabilit');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_STRING', 'Dacă introduceţi aici un text, va fi inserat la începutul tuturor url-urilor pentru acel component. Nu este folosit în mod normal, dar este aici pentru compatibilitate cu URL-ul vechi de la alte componente SEF.');
define('COM_SH404SEF_TT_NAME_BY_COMP', '. <br />Puteţi scrie un nume care va fi folosit în locul numelui elementului din meniu. Pentru a face asta, vă rugam mergeţi la tab-ul <strong>După component</strong>. Reţineţi că acest text va fi invariabil si de pildă nu va fi tradus.');
define('COM_SH404SEF_STANDARD_ADMIN', 'Click aici pentur a schimba la afişarea standard (doar cu parametrii principali)');
define('COM_SH404SEF_ADVANCED_ADMIN', 'Click aici pentru a schimba la afişarea extinsă (cu toţi parametrii disponibili)');
define('COM_SH404SEF_MULTIPLE_H1_TO_H2', 'Schimbă tag-urile h1 multiple în h2');
define('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2', 'Dacă e setat ca Da, şi există mai multe tag-uri h1 într-o pagină, acestea vor fi schimbate în tag-ul h2.<br />Dacă există doar un tag h1 într-o pagină, acesta va fi lăsat neatins.');
define('COM_SH404SEF_INSERT_NOFOLLOW_PDF_PRINT', 'Inserează tag-ul nofollow în link-urile de Print si PDF');
define('COM_SH404SEF_TT_INSERT_NOFOLLOW_PDF_PRINT', 'Dacă e setat ca Da, atributul rel=nofollow va fi adaugat la toate link-urile PDF si Print create de Joomla!. Acest lucru reduce conţinutul duplicat văzut de motoarele de căutare.');
define('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE', 'Inserează titlul în link-urile ... Citeşte tot');
define('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE', 'Dacă e setat ca Da, şi un link Citeşte tot este afişat pe pagină, titlul corespunzător conţinutuluithe va fi inserat în link, pentru a imbunătăţi greutatea link-ului în motoarele de căutare');

define('COM_SH404SEF_VM_USE_ITEMS_PER_PAGE', 'Folosind element în listă drop down pe pagină');
define('COM_SH404SEF_TT_VM_USE_ITEMS_PER_PAGE', 'Dacă e setat ca Da, URL-urile vor fi ajustate pentru a permite folosirea de liste drop down pentru a lăsa utilizatorul să selecteze numărul de produse pe pagină. Dacă nu folosiţi liste drop down, si URL-urile dvs. sunt deja indexate de motoarele de căutare, îl puteţi seta ca NU pentru a păstra URL-ul existent. ');
define('COM_SH404SEF_CHECK_POST_DATA', 'Verifică de asemenea si datele din form-uri (POST)');
define('COM_SH404SEF_TT_CHECK_POST_DATA', 'Dacă e setat ca Da, datele care vin din forum-urile input vor fi verificate vor fi verificate împotriva variabilelor care trec de configurare sau ameninţări similare. Acest lucru poate provoca blocaje care nu sunt necesare în cazul în care aveţi, de exemplu, un forum unde utilizatorii pot discuta lucruri, cum ar fi programarea Joomla sau lucruri similare. Ei ar putea discuta exact despre şiruri de text pe care noi le blocăm considerându-le un potenţial atac. Ar trebui să dezactivaţi această funcţie dacă aveţi probleme.');
define('COM_SH404SEF_SEC_STATS_TITLE', 'Statistici securitate');
define('COM_SH404SEF_SEC_STATS_UPDATE', 'Click aici pentru a actualizare contoare atacuri blocate');
define('COM_SH404SEF_TOTAL_ATTACKS', 'Contor atacuri blocate');
define('COM_SH404SEF_TOTAL_CONFIG_VARS', 'variabila mosConfig în URL');
define('COM_SH404SEF_TOTAL_BASE64', 'Injecţie Base64');
define('COM_SH404SEF_TOTAL_SCRIPTS', 'Injecţie Script');
define('COM_SH404SEF_TOTAL_STANDARD_VARS', 'Variabile standard ilegale');
define('COM_SH404SEF_TOTAL_IMG_TXT_CMD', 'Includere de fişiere la distanţă');
define('COM_SH404SEF_TOTAL_IP_DENIED', 'Adresă IP blocată');
define('COM_SH404SEF_TOTAL_USER_AGENT_DENIED', 'User agent blocat');
define('COM_SH404SEF_TOTAL_FLOODING', 'Pre multe cereri (flooding)');
define('COM_SH404SEF_TOTAL_PHP', 'Respingere de Project Honey Pot');
define('COM_SH404SEF_TOTAL_PER_HOUR', ' /h');
define('COM_SH404SEF_SEC_DEACTIVATED', 'Sec. functions not in use');
define('COM_SH404SEF_TOTAL_PHP_USER_CLICKED', 'PHP, but user clicked');
define('COM_SH404SEF_PREPEND_TO_PAGE_TITLE', 'Insert before page title');
define('COM_SH404SEF_TT_PREPEND_TO_PAGE_TITLE', 'Any text entered her will be prepended to all page title tags.');
define('COM_SH404SEF_APPEND_TO_PAGE_TITLE', 'Append to page title');
define('COM_SH404SEF_TT_APPEND_TO_PAGE_TITLE', 'Any text entered here will be appended to all page title tags.');
define('COM_SH404SEF_DEBUG_TO_LOG_FILE', 'Log debug info to file');
define('COM_SH404SEF_TT_DEBUG_TO_LOG_FILE', 'If set to Yes, sh404SEF will log to a text file many internal information. This data will help us troubleshoot problems you may be facing using sh404SEF. <br/>Warning: this file can quickly become fairly big. Also, this function will certainly slow down your site. Be sure to turn it on only when required. For this reason, it will de-activate automaticaly one hour after being started. Just turn it off then on again to activate it again. The log file is located in /administrator/components/com_sh404sef/logs/ ');

define('COM_SH404SEF_ALIAS_LIST', 'Listă alias');
define('COM_SH404SEF_TT_ALIAS_LIST', 'Scrieţi aici o listă de alias-uri pentru acest URL. Puneţi un singur alias pe linie, ca :<br/>url-vechi.html<br/>sau<br/>celalalt-url-vechi.php?var=12&test=15<br>sh404SEF va face o redirecţionare 301 către URL-ul SEF curent dacă unul din aceste alias-uri va fi accesat.');
define('COM_SH404SEF_HOME_ALIAS', 'Alias Home page');
define('COM_SH404SEF_TT_HOME_PAGE_ALIAS_LIST', 'Scrieţi aici o listă de alias-uri pentru home page-ul dvs. Puneţi un singur alias pe linie, ca :<br/>url-vechi.html<br/>or<br/>celalalt-url-vechi.php?var=12&test=15<br>sh404SEF va face o redirecţionare 301 către home page dacă unul din aceste alias-uri va fi accesat');

define('COM_SH404SEF_INSERT_OUTBOUND_LINKS_IMAGE', 'Inserează simbol link-uri outbound');
define('COM_SH404SEF_TT_INSERT_OUTBOUND_LINKS_IMAGE', 'Dacă e setat ca Da, on simbol vizual va fi inserat lângă fiecare link care duce către alt website, pentru a identifica cu uşurinţă aceste link-uri.');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_BLACK', 'Foloseşte simbol negru');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_WHITE', 'Foloseşte simbol alb');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE', 'Culoare simbol link-uri Outbound');
define('COM_SH404SEF_TT_OUTBOUND_LINKS_IMAGE', 'Imanginile amândouă au background transparent. Selectaţi pe cea neagră dacă site-ul dvs. are un background alb. Selectaţi pe cea albă dacă site-ul are un background de culoare închisă. Aceste imagini sunt  /administrator/components/com_sef/images/external-white.png and external-black.png. Au mărimea de 15x16 pixeli.');

// V 1.3.3
define('COM_SH404SEF_DEFAULT_PARAMS_TITLE', 'Foarte avansat.');
define('COM_SH404SEF_DEFAULT_PARAMS_WARNING', 'AVERTISMENT: schimbaţi aceste valori doar dacă ştiţi ce faceţi! În caz de greşeli vă face daune site-ului.');

// V 1.0.12
define('COM_SH404SEF_USE_CAT_ALIAS', 'Foloseşte alias categorie');
define('COM_SH404SEF_TT_USE_CAT_ALIAS', 'Dacă e setat ca <strong>Da</strong>, sh404sef va folosi alias-ul categoriei în locul numelui actual de fiecare dată când acest nume este necesar pentru crearea unui URL');
define('COM_SH404SEF_USE_SEC_ALIAS', 'Foloseşte alias secţiune');
define('COM_SH404SEF_TT_USE_SEC_ALIAS', 'Dacă e setat ca <strong>Da</strong>, sh404sef va folosi alias-ul secţiunii în locul numelui actual de fiecare dată când acest nume este necesar pentru crearea unui URL');
define('COM_SH404SEF_USE_MENU_ALIAS', 'Foloseşte alias meniu');
define('COM_SH404SEF_TT_USE_MENU_ALIAS', 'Dacă e setat ca <strong>Da</strong>, sh404sef va folosi alias-ul uniu element din meniu în locul titlului actual  de fiecare dată când acesta este necesar pentru crearea unui URL');
define('COM_SH404SEF_ENABLE_TABLE_LESS', 'Use table-less output');
define('COM_SH404SEF_TT_ENABLE_TABLE_LESS', 'Dacă e setat ca <strong>Da</strong>, sh404sef va face ca Joomla să folosească doar tag-uri div (fără tag-uri table) atunci când arată conţinutul, indiferent de tema pe care o utilizaţi. Nu trebuie să ştergeţi tema Beez pentru ca acesta să funcţioneze. Tema Beez este instalată de la început cu Joomla.<br /><strong>AVERTISMENT</strong> : va trebui să adaptaţi foaia de stil pentru a se potrivi cu acest format nou de ieşire html.');

// V 1.0.13
define( 'COM_SH404SEF_JC_MODULE_CACHING_DISABLED', 'Caching for Joomfish language selection module has been disabled!');

// V 1.5.3
define('COM_SH404SEF_ALWAYS_APPEND_ITEMS_PER_PAGE', 'Adaugă întotdeauna #elementelor pe pagină');
define('COM_SH404SEF_TT_ALWAYS_APPEND_ITEMS_PER_PAGE', 'Dacă e setat ca <strong>Da</strong>, sh404sef va adăuga numărul elementelor pe pagină la url-urile paginate. De exemplu, .../Pagina-2.html va deveni .../Pagina2-10.html, în cazul în care setările curente arată 10 elemente pe pagină. Acest lucru este necesar, de exemplu, dacă aţi activat listele verticale pentru a permite utilizator să selecteze numărul de articole pe pagină.');

define('COM_SH404SEF_REDIRECT_CORRECT_CASE_URL', 'Redirecţionează 301 url-ul corect');
define('COM_SH404SEF_TT_REDIRECT_CORRECT_CASE_URL', 'Dacă e setat ca <strong>Da</strong>, sh404sef va face o redirecţionare 301 redirect de la un url SEF daca nu e acelaşi cu un url găsit un baza de date. De exemplu, example.com/Pagina-mea.html va fi redirecţionat la example.com/pagina-mea.html, în cazul în care acesta din urmă este stocat în baza de date. Schimbă , example.com/pagina-mea.html va fi redireţionat la example.com/Pagina-mea.html în cazul care cel din urmă este folosit în site-ul dvs., şi de aceea este stocat in baza de date.');

// V 1.5.5
define('COM_SH404SEF_JOOMLA_LIVE_SITE', 'Joomla live_site');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE', 'Ar trebui să vedeţi aici URL-ul rădăcina site-ul dvs. De exemplu:<br />http://www.example.com<br/>sau<br/> http://example.com<br />(fără slash la final)<br />Aceasta nu este o setare sh404sef, ci o setare <b>Joomla</b>. Este stocat in propriul fişier Joomla configuration.php.<br />Joomla va detecta în mod normal, adresa rădăcină. Cu toate acestea, în cazul în care adresa afişată aici nu este corectă, ar trebui să setaţi singur manual. Acest lucru îl puteţi face modificând conţinutul a fişierului configuration.php (de obicei folosind FTP-ul).<br/>Simptomele legate de o valoare greşită sunt: şabloanele sau imaginile nu vor fi afişate, butoane nu funcţionează, toate stilurile (culori, fonturi, etc) lipsesc');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE_MISSING', 'AVERTISMENT: $live_site lipseşte din fişierul configuration.php al Joomlei, sau nu începe cu "http://" sau "https://" !');
define('COM_SH404SEF_JCL_INSERT_EVENT_ID', 'Inserează ID eveniment');
define('COM_SH404SEF_TT_JCL_INSERT_EVENT_ID', 'Dacă e setat ca Da, ID-ul intern al evenimentului va fi prefixat la titlul evenimentului în url-uri, pentru a le face unice');
define('COM_SH404SEF_JCL_INSERT_CATEGORY_ID', 'Inserează ID categorie');
define('COM_SH404SEF_TT_JCL_INSERT_CATEGORY_ID', 'Dacă e setat ca Da, atunci când este folosită o categorie în url, aceasta va fi prefixată cu id-ul internet al său, pentru a o face unică.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_ID', 'Inserează ID calendar');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_ID', 'Dacă e setat ca Da, atunci când numele unui calendar este folosit într-un url, acesta fa fi prefixat cu id-ul internet al calendarului, pentru a-l face unic');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_NAME', 'Inserează nume Calendar');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_NAME', 'Dacă e setat ca Da, toate url-urile unde un calendar specific este setat vor avea acel nume al calendarului inclus în url. Dacă nici un id calendar nu este specificat în url, titlul elementului din meniu va fi inclus în schimb');
define('COM_SH404SEF_JCL_INSERT_DATE', 'Insereză dată');
define('COM_SH404SEF_TT_JCL_INSERT_DATE', 'Dacă e setat ca Da, data a paginii ţintă va fi inserată în fiecare url');
define('COM_SH404SEF_JCL_INSERT_DATE_IN_EVENT_VIEW', 'Inserează dată în link-ul evenimentului');
define('COM_SH404SEF_TT_JCL_INSERT_DATE_IN_EVENT_VIEW', 'Dacă e setat ca Da, fiecare dată a evenimentelor va fi prefixată la url-urile către pagina detaliilor evenimentului');
define('COM_SH404SEF_JCL_TITLE', 'Configurare JCal Pro');
define('COM_SH404SEF_PAGE_TITLE_TITLE', 'Configurare Titlu Pagină');
define('COM_SH404SEF_CONTENT_TITLE_TITLE', 'Configurare titlu pagină conţinut Joomla');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_SECTION', 'Inserează secţiune');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_SECTION', 'Dacă e setat ca Da, secţiunea articolului va fi inserată în titlul paginii articolului');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_CAT', 'Insearază categorie');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_CAT', 'Dacă e setat ca Da, categoria articolului va fi inserată în titlul paginii articolului');
define('COM_SH404SEF_CONTENT_TITLE_USE_ALIAS', 'Foloseşte alias-ul titlului articolului');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_ALIAS', 'Dacă e setat ca Da, alias-ul articolului va fi folosit în titlul paginii în locul titlului actual al articolului');
define('COM_SH404SEF_CONTENT_TITLE_USE_CAT_ALIAS', 'Foloseşte alias-ul categoriei');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_CAT_ALIAS', 'Dacă e setat ca Da, alias-ul categoriei va fi folosit în titlul paginii în locul titlului actual categoriei');
define('COM_SH404SEF_CONTENT_TITLE_USE_SEC_ALIAS', 'Foloseşte alias-ul secţiunii');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_SEC_ALIAS', 'Dacă e setat ca Da, alias-ul secţiunii va fi folosit în titlul paginii în locul titlului actual al secţiunii');
define('COM_SH404SEF_PAGE_TITLE_SEPARATOR', 'Separator titlu pagină');
define('COM_SH404SEF_TT_PAGE_TITLE_SEPARATOR', 'Introduceţi aici un caracter sau un text pentru a separa părţile titlului paginii, dacă există mai mult de una. Predefinit este caracterul | character, înconjurat de un singur spaţiu');

// V 1.5.7
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_TITLE', 'Duplicări');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_NOT', 'Arată doar url-ul principal');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS', 'Arată url-ul principal şi pe cele duplicate');
define('COM_SH404SEF_INSERT_ARTICLE_ID_TITLE', 'Inserează id articol în URL');
define('COM_SH404SEF_TT_INSERT_ARTICLE_ID_TITLE', 'Dacă e setat ca <strong>Da</strong>, id-ul intern al articolului va fi adăugat la titlul articolului in URL-uri, pentru a putea fi sigur că fiecare articol poate fi accesat indivitual, chiar dacă două articole au exact acelaşi titlu, sau titlurile care duc la acelaşi URL (după ce au fost curăţate de caractere invalide). Acest id nu va aduce nici o valoare SEO, şi trebuie să vă mai degrabă că nu aveţi articole cu acelaşi titlu în aceeaşi secţiune şi categorie.<br />În cazul în care nu controlaţi articolele scrise, această setare vă poate ajuta să asiguraţi-vă că articolele pot fi accesate, la costul unei bune optimizări în motorul de căutare.');

// V 1.5.8

define('COM_SH404SEF_JS_TITLE', 'Configurare JomSocial');
define('COM_SH404SEF_JS_INSERT_NAME', 'Inserează nume JomSocial');
define('COM_SH404SEF_TT_JS_INSERT_NAME', 'Dacă e setat ca <strong>Da</strong>, titlul elementului din meniu care duce la pagina principală a JomSocial va fi prefixat la toate URL-urile SEF ale JomSocial');
define('COM_SH404SEF_JS_INSERT_USER_NAME', 'Inserează username-ul');
define('COM_SH404SEF_TT_JS_INSERT_USER_NAME', 'Dacă e setat ca <strong>Da</strong>, username-ul va fi inserat în URL-urile SEF. <strong>AVERTISMENT</strong>: acest lucru poate duce la creşterea substanţială a mărimii bazei de date şi vă poate încetini site-ul, dacă aveţi mulţi utilizatori înregistraţi.');
define('COM_SH404SEF_JS_INSERT_USER_FULL_NAME', 'Inserează nume complet');
define('COM_SH404SEF_TT_JS_INSERT_USER_FULL_NAME', 'Dacă e setat ca <strong>Da</strong>, numele complet al utilizatorului va fi inserat în URL-urile SEF. <strong>AVERTISMENT</strong>: aceast lucru poate duce la creşterea substanţială a mărimii bazei de date, şi vă poate încetini site-ul dacă aveţi mulţi utilizatori înregistraţi.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY', 'Inserează categorie grup');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY', 'Dacă e setat ca <strong>Da</strong>, numele categoriei grupului va fi inserat în URL-ul SEF.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY_ID', 'Inserează ID categorie grup');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul categoriei grupului va fi prefixat la numele categoriei <strong>când opţiunea anterioară este setată ca Da de asemeni</strong>, în caz că două categorii au acelaşi nume.');
define('COM_SH404SEF_JS_INSERT_GROUP_ID', 'Inserează ID grup');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul grupului va fi prefixat la numele grupului, în caz că două grupuri au acelaşi nume.');
define('COM_SH404SEF_JS_INSERT_GROUP_BULLETIN_ID', 'Inserează ID buletin grup');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_BULLETIN_ID', 'Dacă e setat ca <strong>Da</strong>, a users group bulletin ID will be prepended to the bulletin name, just in case two bulletins have the same name.');
define('COM_SH404SEF_JS_INSERT_DISCUSSION_ID', 'Inserează ID discuţie grup');
define('COM_SH404SEF_TT_JS_INSERT_DISCUSSION_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul discuţiei într-un grup va fi prefixat la numele discuţiei, în caz că două discuţii au acelaşi nume.');
define('COM_SH404SEF_JS_INSERT_MESSAGE_ID', 'Inserează ID mesaj');
define('COM_SH404SEF_TT_JS_INSERT_MESSAGE_ID', 'Dacă e setat ca <strong>Da</strong>, ID-ul mesajului va fi prefixat la numele mesajului, în caz că două mesaje au acelaşi nume.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM', 'Inserează nume album foto');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM', 'Dacă e setat ca <strong>Da</strong>, numele albumului de care aparţine va fi inserat în URL-urile SEF a fotografiilor.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM_ID', 'Inserează ID album foto');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM_ID', 'Dacă e setat ca <strong>Da</strong>, un ID al albumului va fi prefixat la numele albumului, in caz că există două albume cu acelşi nume.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ID', 'Inserează ID fotografie');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ID', 'Dacă e setat ca <strong>Da</strong>, un ID al fotografiei va fi prefixat la numele fotografiei, în caz că există două poze care au acelaşi nume.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT', 'Inserează nume categorie videoclipuri');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT', 'Dacă e setat ca  <strong>Da</strong>, numele categoriei din care face parte va fi inserat în URL-ul SEF al videoclipurilor.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT_ID', 'Insereză ID categorie videolipuri');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT_ID', 'Dacă e setat ca <strong>Da</strong>, un ID al categoriei va fi prefixat la numele categoriei, în caz că două categorii au acelaşi nume.');
define('COM_SH404SEF_JS_INSERT_VIDEO_ID', 'Inserează ID videoclip');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_ID', 'Dacă e setat ca <strong>Da</strong>, un ID al videoclipului va fi prefixat la numele videoclipului, în caz că două videoclipuri au acelaţi titlu.');

define('COM_SH404SEF_FB_INSERT_USERNAME', 'Inserează username');
define('COM_SH404SEF_TT_FB_INSERT_USERNAME', 'Dacă e setat ca <strong>Da</strong>, username-ul va fi inserat în URL-ul SEF penru mesajele lui sau profil.');
define('COM_SH404SEF_FB_INSERT_USER_ID', 'Inserează ID user');
define('COM_SH404SEF_TT_FB_INSERT_USER_ID', 'Dacă e setat ca <strong>Da</strong>, un ID va fi prefixat numelui său, dacă setarea precedentă este setată ca da, în caz că doi utilizatori au acelaşi username.');
define('COM_SH404SEF_PAGE_NOT_FOUND_ITEMID', 'Itemid-ul folosit la pagina 404');
define('COM_SH404SEF_TT_PAGE_NOT_FOUND_ITEMID', 'Valoarea introdusă aici, dacă nu este zerp, va fi folosită pentru afişa pagina 404. Joomla va folosi Itemid-ul pentru a decide care template sau module să fie afişate. Itemid-ul reprezintă un element din meniu, deci vă puteţi uita după ItemId-uri în lista de meniuri.');
//define('', '');
