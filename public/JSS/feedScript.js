class services {


    async like(postId) {
        let jsonBody = JSON.stringify({ 'postId': postId });

       
        await fetch('/likejs', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
    }
    async likecounts(postId) {
        let jsonBody = JSON.stringify({ 'postId': postId });

        let response = await fetch('/likecount', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
        
        return response.json();
    }

    async cmntscounts(postId) {
        let jsonBody = JSON.stringify({ 'postId': postId });

        let response = await fetch('/countCommentjs', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
        
        return response.json();
    }

    async comment(postId, text) {
        let jsonBody = JSON.stringify({ 'postId': postId, 'text': text });

        
        await fetch('/commentjs', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
    }
    async cmntContent(postId) {
        let jsonBody = JSON.stringify({ 'postId': postId });

        let response = await fetch('/cmntContent', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
        return response.json();
    }

    async delCmnt(cmntId) {
        let jsonBody = JSON.stringify({ 'id': cmntId });

       
        await fetch('/delCmnt', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
       
    }
    async editText(postId, newText) {
        let jsonBody = JSON.stringify({ 'post_id': postId, 'new_text': newText });

        
        await fetch('/editText', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });
        
    }

}
service = new services();
async function likkee(postId) {

    root = document.getElementById(postId);


    await service.like(postId);

    let count = await service.likecounts(postId);
    root.innerHTML = count + " Likes";
}
async function hide(postId) {
    remdiv = document.getElementById("dform" + postId);
    cmnt = document.getElementById("c" + postId);
    remdiv.innerHTML = "";

    remdiv.append(cmnt);
    cmnt.setAttribute('onclick', 'comment(' + postId + ')');
}
async function comment(postId) {

    com = await service.cmntContent(postId);
    div = document.getElementById("dform" + postId);
    cmnt = document.getElementById("c" + postId);
    cmnt.setAttribute('onclick', 'hide(' + postId + ')');
   
    div.append(cmnt);
    let count = await service.cmntscounts(postId);
    cmnt.innerText = count + " comments";
    let inp = document.createElement('input');
    let sub = document.createElement('button');
    sub.innerText = "send comment";
    inp.name = "comment_text";
    inp.type = "text";
    inp.placeholder = "write a comment !";

    sub.addEventListener('click', async (event) => {
        let text = inp.value;
        await service.comment(postId, text);
        hide(postId);
        comment(postId);
    });
    div.append(inp, sub);
    com.forEach((cmnt) => {
        let divv = document.createElement('div');
        divv.className = "userName";
        divv.innerText = cmnt.name;
        let divv2 = document.createElement('div');
        divv2.className = "Comment";
        divv2.innerText = cmnt.cmnt_text;
        div.append(divv, divv2);
    });
   

}

async function mycomment(postId) {
    com = await service.cmntContent(postId);
    div = document.getElementById("dform" + postId);
    cmnt = document.getElementById("c" + postId);
    // div.innerHTML = '';
    cmnt.setAttribute('onclick', 'hide(' + postId + ')');
    div.append(cmnt);
    let count = await service.cmntscounts(postId);
    cmnt.innerText = count + " comments";
    let inp = document.createElement('input');
    let sub = document.createElement('button');
    sub.innerText = "send comment";
    inp.name = "comment_text";
    inp.type = "text";
    inp.placeholder = "write a comment !";

    sub.addEventListener('click', async (event) => {
        let text = inp.value;
        await service.comment(postId, text);
        hide(postId);
        mycomment(postId);
    });
    div.append(inp, sub);
    com.forEach((cmnt) => {
        let divv = document.createElement('div');
        divv.className = "userName row";
        divv.innerText = cmnt.name;
        let divv2 = document.createElement('div');
        divv2.className = "Comment row";
        let comnt = document.createElement('p');
        comnt.className = "col Comment"
        comnt.innerText = cmnt.cmnt_text;
        let del = document.createElement('button');
        del.className = "col-md-auto justify-content-right";
        del.innerText = " Delete";
        divv2.append(comnt, del);
        div.append(divv, divv2);
        del.addEventListener('click', () => {
            service.delCmnt(cmnt.id);
            hide(postId);
            mycomment(postId);
        });
    });
  

}

async function edit(postId) {
    root = document.getElementById("editableText" + postId);
    let br = document.createElement('br');
    let ed = document.createElement('input');
    ed.className = "col-md-auto  ed";
    ed.placeholder="Adjust your text!"

    let sub = document.createElement('button');
    sub.className = "col-md-auto justify-content-right";
    sub.innerText = " edit";
    root.append(br, ed, sub);
    
    sub.addEventListener('click', async (event) => {

        await service.editText(postId, ed.value);
        root.innerHTML = "";

        root.innerText = ed.value;

    })
}

function login() {
    alert("Login to benifit from our services :)");
}
function confirmm(postId) {
    let btn = postId + "del";
    let att = document.getElementById(btn);
    let r = confirm("are you sure you want to delete this post?");
    if (r) {
        att.submit();
    }
}