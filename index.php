<!DOCTYPE html>
<html >
<head>
	<title>Чат</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<style>
		h2 {
			text-align: center;
		}
		#chat, table {
			margin: 0 auto;
		}
		#chat {
			border: 3px solid #0ff;
			height: 300px;
			margin: 0 auto;
			overflow-x: none;
			overflow-y: auto;
			width: 200px;
		}
		p {
			margin: 0;
		}
	</style>
	<script type="text/javascript">
		var array = new Array ();
		function getXmlHttp () {
			var xmlhttp;
			try {
				xmlhttp = new ActiveXObject("Msxm12.XMLHTTP");
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					xmlhttp = false;
				}
			}
			if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
				xmlhttp = new XMLHttpRequest();
			}
			return xmlhttp;
		}
		function chat() {
			var xmlhttp = getXmlHttp();
			xmlhttp.open("POST", "functions.php", true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send("update=1");
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {
					if (xmlhttp.status == 200) {
						var response = xmlhttp.responseText;
						response = JSON.parse(response);
						if (array.length == response.length) return;
						var start = array.length;
						array = response;
						var messages = document.getElementById("chat").innerHTML;
						for (i = start; i < array.length; i++) {
							messages = messages + "<p><b>" + array[i].name + ":</b> " + array[i].message + "</p>";
						}
						document.getElementById("chat").innerHTML = messages;
						document.getElementById("chat").scrollTop = 1000000;
					}
				}
			}
			setTimeout("chat()", 1000);
		}
		
		function addMessage() {
			var name = document.getElementById("name").value;
			var message = document.getElementById("message").value;
			var xmlhttp = getXmlHttp();
			xmlhttp.open("POST", "functions.php", true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send("name=" + encodeURIComponent(name) + "&message=" + encodeURIComponent(message));
		}
	</script>
</head>
<body onload="chat()">
	<h2>Чат</h2>
	<div id="chat">
	</div>
	<br />
	<table>
		<tr>
			<td>Имя:</td>
			<td>
				<input type="text" id="name" />
			</td>
		</tr>
		<tr>
			<td>Сообщение:</td>
			<td>
				<input type="text" id="message" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="button" value="Отправить" onclick="addMessage()" />
			</td>	
		</tr>
	</table>
</body>
</html>