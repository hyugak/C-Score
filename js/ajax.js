var myajax;
function AjaxConnect(container,accessurl,paramet,method) {
    jQuery.noConflict();
    jQuery(document).ready(function(){
	// ここでは、$はprototypeの動作をします。
	// jQueryオブジェクトとしての$は一切使えず、その場合は$()ではなくjQuery()と表記する必要があります。

    
	myajax = new Ajax.PeriodicalUpdater(
		container,
		accessurl,
		{
			"method": method,
			"parameters": paramet,
			frequency: 3600, // 1時間ごとに実行
			onSuccess: function(request) {
				// 成功時の処理を記述
				// alert('成功しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
				
				// ↓IEでもキャッシュを読み込まずに毎回リモート接続を実行するためのコード(パラメータの書き換え)
				var str = myajax.options.parameters;
				var hash = str.parseQuery();
				hash["ajax_request_id"] = Math.random();
				hash = $H(hash);
				myajax.options.parameters = hash.toQueryString();
			},
			onComplete: function(request) {
				// 完了時の処理を記述
				// alert('読み込みが完了しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
			},
			onFailure: function(request) {
				alert('読み込みに失敗しました');
			},
			onException: function (request) {
				alert('読み込み中にエラーが発生しました');
			}
		}
	);
    
    });
}
function AjaxConnectStop() {
	if (myajax != null && myajax != undefined) {
		myajax.stop();
	}
}