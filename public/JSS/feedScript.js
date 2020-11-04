class services{

   async getPosts() {
      let response = await fetch('/feedss');
       return response.json();
   }
    
    async like(postId) {
    let jsonBody = JSON.stringify({'postId':postId});
      
       // let response = 
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
        let jsonBody = JSON.stringify({'postId':postId});
          
     let response = await fetch('/likecount', {
                method: 'POST',
                body: jsonBody,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
     });
       // console.log();
        return response.json();
    }
    
    async cmntscounts(postId) {
        let jsonBody = JSON.stringify({'postId':postId});
          
     let response = await fetch('/countCommentjs', {
                method: 'POST',
                body: jsonBody,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
     });
       // console.log();
        return response.json();
    }

    async comment(postId,text) {
        let jsonBody = JSON.stringify({'postId':postId,'text':text});
          
           // let response = 
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
        let jsonBody = JSON.stringify({'postId':postId});
          
            let response =  await fetch('/cmntContent', {
                method: 'POST',
                body: jsonBody,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            });
        return response.json();
    }
}
service = new services();
async function likkee(postId){

    root = document.getElementById(postId);

        
            await service.like(postId);
            
            let count = await service.likecounts(postId);
            root.innerHTML = count + " Likes";
}
    
async function comment(postId) {
    com=await service.cmntContent(postId);
    div = document.getElementById("dform" + postId);
    cmnt = document.getElementById("c" + postId);
    div.innerHTML = '';
    div.append(cmnt);
    let count = await service.cmntscounts(postId);
    cmnt.innerText = count + " comments";
    let inp = document.createElement('input');
    let sub = document.createElement('button');
    sub.innerText = "send comment";
    inp.name = "comment_text";
    inp.type = "text";
    inp.placeholder = "write a comment !";
    
    sub.addEventListener('click', async(event) => {
        let text = inp.value; 
       await service.comment(postId, text);
       
        comment(postId);
    });
    div.append(inp,sub);
    com.forEach((cmnt) => {
        let divv = document.createElement('div');
        divv.className = "userName";
        divv.innerText = cmnt.name;
        let divv2 = document.createElement('div');
        divv2.className = "Comment";
        divv2.innerText = cmnt.cmnt_text;
        div.append(divv,divv2);
});
    root = document.getElementById(postId);



        
            // await service.like(postId);
            
            // let count = await service.likecounts(postId);
            // root.innerHTML = count + " Likes";
    }
