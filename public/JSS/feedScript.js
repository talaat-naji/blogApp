class services {


    async like(postId, notifId) {
        let jsonBody = JSON.stringify({ 'postId': postId, 'notifId': notifId });


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

    async comment(postId, text,notifId) {
        let jsonBody = JSON.stringify({ 'postId': postId, 'text': text ,'notifId':notifId });


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

    async notifications() {

        let response = await fetch('/notifications', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        return response.json();
    }

    async showPost(postId) {
        let jsonBody = JSON.stringify({ 'post_id': postId });


        await fetch('/post', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

    }

    async addFriends(uId) {
        let jsonBody = JSON.stringify({ 'toBeAdded': uId });
       
      //  prompt(uId);
      let response=  await fetch('/addFriend', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
      });
       // prompt(response);
        return response.json();
    }

    async getFollowStat(uId) { 
        let jsonBody = JSON.stringify({ 'toBeChecked': uId });
        let response=  await fetch('/followStat', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
      });
       // prompt(response);
        return response.json();
    }

}
service = new services();
async function likkee(postId, notifId) {

    root = document.getElementById(postId);


    await service.like(postId, notifId);

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
async function comment(postId,notifId) {

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
        await service.comment(postId, text,notifId);
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

async function mycomment(postId,notifId) {
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
        await service.comment(postId, text,notifId);
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
    ed.placeholder = "Adjust your text!"

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
async function testnot() {
    let res = await service.notifications();
    return res;
}
async function test() {
    let res = await service.notifications();
    // console.log(res);
    let not = document.getElementById('notif');
    let dropBox = document.createElement('div');
    dropBox.className = 'dropdown-content scroll';
    not.append(dropBox);
    res.forEach((val) => {
        let notification = document.createElement('div');
        notification.className = "btn navbar";
        if (val.read_at != null) {
            notification.className = "btn navbar read";
}else{notification.className = "btn navbar unread";}

        let btn = document.createElement('button');
        btn.className = "btn navbar";

        let form = document.createElement('form');
        form.setAttribute('action', '/post');
        form.setAttribute('method', 'POST');
        if (val.type == "App\\Notifications\\likedYourPost") {
            btn.innerText = val.data.usName + " liked your post " + val.data.post_id;
        }
        if (val.type == "App\\Notifications\\CommentedYourPost") {
            btn.innerText = val.data.usName + " commented on your post " + val.data.post_id;
        }
        let inp = document.createElement('input');
        inp.type = 'hidden';
        inp.value = val.data.post_id;
        inp.name = "post_id";
        let inpnotId = document.createElement('input');
        inpnotId.type = 'hidden';
        inpnotId.value = val.id;
        inpnotId.name = "notId";
        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let inpcsrf = document.createElement('input');
        inpcsrf.type = 'hidden';
        inpcsrf.value = csrf;
        inpcsrf.name = "_token";
        form.append(inpnotId,inpcsrf, inp, btn);

        notification.append(form);
        dropBox.append(notification);
    });

}
test();

async function addFriend(uId) { 
    let approved = await service.addFriends(uId);
  
    let followbtn = document.getElementById('followbtn' + uId);
    
    if (approved == '') { followbtn.innerText = 'Follow'; }
    else {
        approved.forEach((approve) => {
       
            if (approve.approved == 1) {
                followbtn.innerText = 'Following';
            }
          
        });
  
    }
}
async function getFollowStatus(uId) {

    let approved = await service.getFollowStat(uId);
  
    let followbtn = document.getElementById('followbtn' + uId);
    
    if (approved == '') { followbtn.innerText = 'Follow'; }
    else {
        approved.forEach((approve) => {
       
            if (approve.approved == 1) {
                followbtn.innerText = 'Following';
            }
          
        });
  
    }
}