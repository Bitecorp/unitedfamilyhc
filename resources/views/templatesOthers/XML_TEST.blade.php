
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                
                <title>XML TEST</title>
            </head>
            <body style="margin-top: -25px !important;">
        <p><template lang="COBOL" type="IMS"></p>
<p><dbd>DJ1E</dbd></p>
<p><dbdlib><span class="ph"><span class="keyword">FM</span></span>IMS.XTEST.DBDLIB</dbdlib></p>
<p><copybooks></p>
<p><library><span class="ph"><span class="keyword">FMN</span></span>.IMS.IVP.COPYLIB.COBOL</library></p>
<p><member name="SHIRE" lib="1" segname="SHIRE"> </member></p>
<p><member name="SHIRENP" lib="1" segname="SHIRENP"> </member></p>
<p><member name="LINKSUB" lib="1" segname="LINKSUB"> </member></p>
<p><cobol maxrc="4"> </cobol> </copybooks></p>
<p><layout name="SHIRE" copybook="SHIRE" segment="SHIRE"></p>
<p><criteria type="ID"></p>
<p><exp><![CDATA[#4 = '1']]></exp></p>
<p></criteria></p>
<p></layout></p>
<p><layout name="SHIRE-TOWN" copybook="SHIRE" segment="SHIRE"></p>
<p><criteria type="ID"></p>
<p><exp><![CDATA[#4 = '2']]></exp></p>
<p></criteria></p>
<p></layout></p>
<p><layout name="SHIRE-CITY" copybook="SHIRE" segment="SHIRE"></p>
<p><criteria type="ID"></p>
<p><exp><![CDATA[#4 = '3']]></exp></p>
<p></criteria></p>
<p></layout></p>
<p><layout name="SHIRE-NON-PUBLIC" copybook="SHIRENP" segment="SHIRENP"> </layout></p>
<p><layout name="SHIRE-SUBURB" copybook="LINKSUB" segment="LINKSUB"> </layout></p>
<p></template></p>
<![CDATA[#4 = '2']]>
<p>&nbsp;</p>
<![CDATA[#4 = '3']]>
<p>&nbsp;</p>
            </body>
        </html>
        