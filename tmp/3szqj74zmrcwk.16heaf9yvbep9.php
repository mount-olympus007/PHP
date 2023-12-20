<?php echo $this->render('./header.php',NULL,get_defined_vars(),0); ?>
<?php echo $this->render('./admin_nav.php',NULL,get_defined_vars(),0); ?>

<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title"><?= ($appUser->first_name) ?> <?= ($appUser->last_name) ?></h5>

        <ol style="list-style-type: none;" id="messageList">
        <?php foreach (($chatList?:[]) as $item): ?>
                
                <li style="text-align: right;" id="<?= ($item['UserId']) ?>" data-name="<?= ($item['Sender']) ?>" class="float-right"><p><?= ($item['Message']) ?></p></li>
                
            <?php endforeach; ?>
        </ol>
    </div>
    <div class="card-footer">
        <form>
            <input type="text" name="message" id="message" />
            <input type="hidden" value="<?= ($item['UserId']) ?>" name="userId" id="userId" />
            <input type="hidden" value="<?= ($appUser->branch_id) ?>" name="branchId" id="branchId" />

            <button onclick="SendToUser()">Send</button>
       
        </form>

    </div>
</div>
<div id="chat-box"></div>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script>  
	function showMessage(messageHTML) {
		$('#chat-box').append(messageHTML);
	}

	$(document).ready(function(){
		var websocket = new WebSocket("ws://localhost:9003/flexapp/chat/connect"); 
		websocket.onopen = function(event) { 
            alert();
			showMessage("<div class='chat-connection-ack'>Connection is established!</div>");		
		}
		websocket.onmessage = function(event) {
			var Data = JSON.parse(event.data);
			showMessage("<div class='"+Data.message_type+"'>"+Data.message+"</div>");
			$('#chat-message').val('');
		};
		
		websocket.onerror = function(event){
			showMessage("<div class='error'>Problem due to some Error</div>");
		};
		websocket.onclose = function(event){
			showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
		}; 
		
		$('#frmChat').on("submit",function(event){
			event.preventDefault();
			$('#chat-user').attr("type","hidden");		
			var messageJSON = {
				chat_user: $('#chat-user').val(),
				chat_message: $('#chat-message').val()
			};
			websocket.send(JSON.stringify(messageJSON));
		});
        websocket.op;
	});
</script>
<script>
    let lis = document.getElementsByTagName('li');
    let List = Array.prototype.slice.call(lis);

    List.forEach(element => {
        if(element.getAttribute('id') == element.getAttribute('data-name')){
            element.children[0].setAttribute('style', 'text-align: left; color:red;');
        }
        else{

            element.setAttribute('style', 'text-align: right; color:blue');

        }
    });
    function SendToUser(){
        let message = document.getElementById('message').value;
    let userId = document.getElementById('userId').value;
    let branchId = document.getElementById('branchId').value;

    
    let url = "/flexapp/admin/sendtouser?message="+message+"&userId="+userId+"&branchId="+ branchId;
    fetch(url)
.then(response => response.json()).then(data=> alert('sent'));

    }
 
</script>
<script src="../ui/js/admin.js"></script>
<?php echo $this->render('./footer.php',NULL,get_defined_vars(),0); ?>