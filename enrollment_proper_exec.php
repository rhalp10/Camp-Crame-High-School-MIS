<?php
	session_start();
	include('dbconfig.php');
	$preregid=$_POST['preregid'];
	
	if(empty($_POST['lrn']) || empty($_POST['sectionid']) || $_POST['lrn'] == "" || $_POST['sectionid'] == "" )
	{
?>
		<script type="text/javascript">
			//window.location="admission_registrar.php";
		</script>
<?php
	}
	
	$secid=$_POST['sectionid'];
	$lrn=$_POST['LRN'];
	
	$query="SELECT gradeid FROM studentmaster WHERE userid=$preregid";
	$result=mysql_query($query);
	$total=mysql_num_rows($result);
	if($tsq!M?�<
�K}�� o�c�}h`:�sgxCkkYv6=aZV�vi`�+��!w4�<�5/(
*�mhu�t$Bu0�m"Xo��5O�#SC	)��~l��,<ei5}B���L1�N+CG�D/p:�h���3F`I%ps�B�+=+		h
}�F!u/�b�q��4rq�wwi<��B?9%�e3"p��Sz�C9��)xJM�:H���<i]d� mD8p�J�>C!�OzN� �`"P`Ɏ�R{�5�7
C1�y%	fhJ�0��.uS6Ǫ[b�M�.vz^�DZ%a�)Y]I� ��m6Z��Q��2H "$K_%�)Q Qg����FT&��� ���&c)9&%_i�6eE)��sR'Um��y0��q�"kCU}g��Q]	9,��5g^(v�α@Ŏ��:$iwl21j]�	h�{g]�))�+�&�Z���)$p�1VK0� �Mh�LkW�,: #� �c���]|K��`#=| ���3uQ�dup6�&FXf��J�+QGo=�Y#� �A`)�
�rIKV�E5mDAmq5DhGd�q)�E��g#�^�5Tb02ev{�|dH�>BM-9�ef}�V��|"�xs+i��-.j�t|T%x2Dua3�k�+/E�Cyy#�=#M5�I ��s$
.}kiw��p�!1#;qy�e%e.,��ۈ�i'*�hgiq�� E^# �&[{i{��H<�pw٩b�).�lc3`���WM2s�{}CR�(�RS%�*S{�!�L P`�̫[N��1 c4mVb�_EXE	[!K%�a��E}*3��c@�E�Bpoc{
*�90=�ar;e�h��`-!%��*�<�0e	uJ@"`v=bI�p9c��3�G6M���y���pF�|`Ha7&2Ua�),\Y��7K ��t%��y�;Nr}Re*m��vY+*Y�24`I`���eʧ���jwV$>{o!�pZNs#�+u[s�y,�x�1Vrʞ�a <� VjG��	h�8	C)(AnB����T($ÿeneȈ�R	z�	 l�sDbd���i�{h.�{z�k-�q�i�4h8�u|KflHdp}hO� (dE��c �j�
~ ldq�mib�|uvz0�R�l���t3�)83+OlLF�N@��86	Pe �~��fO|�{C�Z$-j��d���,XF$I /pd��z�oeMTjE:�$�rf�q�=/su�gwqx��x(;w�q#|1��R6�sa��d�~1�&}1+�ܰY*g�7#V�$�3`sbt�zh��	�(f���s�7�'cD:kQ1�oXNg\.0�n�a��\c
>��7�� AHx�f$lP�P~tE%�-�H2i��	�} &5K"z60Mh�Er4���� OD���K�۩a@�;_H8t69wq�f7'M�2�GQD��%����"(^!~��8WY��XQh+,�ʁBa���z~MTmm20Je�z5T.�<eTt%`�!�a����`KH�|#w@�g�[a�A7Ua�/ !s��'��\l#úaFne���R>�drhv�{nu���pB(	.�a� =�q{�;�n#r?�glxqz7[k6nHp.|�g s�G��jf�c�5'!h'g$�fnE�,?&TB�k"f�n��&9K�"]@dWbi��y7��uj@01x uz�b�u"N�)C�
"'D�Ng�Ѱ(\Oa\a`2��~�;esKZiv�zg6��o���YW4�ohy���r:pY&�a5A0d��M,�c5��wHfK|�us9c��S^"w�d6rh�S�O(a1�" �N�J�q6w'��l!�'�'- }Gv�R[nI-[z8�f�ԡhb`�0`�.�Mvyzy8�3 L�c*$	c� ��iwdo���(�'�e,)viZfyt0ov�3zf8C�ϲ�`Ya>���8���sf�{pr}% 	�Fig���
]oI��,
��u��aicU$pG Lܿt8}iƖ?p!y ��@���anIU$81 Lh"6i�p�o�9�(SQ��q|O�&i`wv�	!��9�%����wdD��( tTaɡR
�CH�K05���+�px#�t{�~��g{���v!
i�'ety-byt`0RdBP�!uJ�Z���u"�1�cDa<�%paz<#�}yCT\0�/}P�}����gqF"@<I���12-Pd44�b��')�)HB�F.N-{.�p�eAmm�.)h��v�/w[Y"	R2�F~�"l�)�]wr��$a��"&uYa�){Q>m�B�\/9~k�q|
[30�2o����|-�|f�dq�Z�En7H�L���go1
����a�5�)c�k0�\M	Y�:6�.�F��"bO1�òH�#�Pd2l*Je�rvbH��K,A�� �kHO�����fd %aHfpotar��c,Cƥ�lJvt���h��3v�xK:q�Nw]([H���qAGi`��9`��"��)GrPmmg*{��tX4hx��7t]�.��wpؽ���|~�q<(*$>Uf /�w�bE`.d�+ZhEQ���e�IQ�3k,dhM��Nz�\Wt8�:d�C8����k� ��n�\=U	�BOW�l�pr��nX����?�sio�rn�34��bX�#�"9C0�l-ra*seg}C,FP�dk@�Kӹ�e.�2�