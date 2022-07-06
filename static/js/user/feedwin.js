const url = new URL(location.href);

function getFeedList() {
    if(!feedObj) { return; }
    feedObj.showLoading();
    
    const param = {
        page: feedObj.currentPage++,
        iuser: url.searchParams.get('iuser')
        
    }
    fetch('/user/feed' + encodeQueryString(param))
    .then(res => res.json())
    .then(list => {                
        feedObj.makeFeedList(list);                
    })
    .catch(e => {
        console.error(e);
        feedObj.hideLoading();
    });
}

getFeedList();

(function () {
    const gData = document.querySelector("#gData");
    const spanCntfollower = document.querySelector('#spanCntFollower');
    const btnFollow = document.querySelector("#btnFollow");
    if (btnFollow) {
        btnFollow.addEventListener("click", function () {
        const param = {
            toiuser: parseInt(gData.dataset.toiuser),
        };
        console.log(param);
        const follow = btnFollow.dataset.follow;
        console.log("follow : " + follow);
        const followUrl = "/user/follow";
        switch (follow) {
            case "1": //팔로우 취소 시 버튼 모양 변경
            fetch(followUrl + encodeQueryString(param), { method: "DELETE" })
                .then((res) => res.json())
                .then((res) => { 
                    if (res.result) {
                        btnFollow.dataset.follow = '0';
                        btnFollow.classList.remove('btn-outline-secondary');
                        btnFollow.classList.add('btn-primary');
                        if (btnFollow.dataset.youme === '1') {
                            btnFollow.innerText = '맞팔로우 하기';
                        } else {
                            btnFollow.innerText = '팔로우';
                        }
                        //follower - 1   ~~객체명 = parseInt
                        spanCntfollower.innerText = ~~spanCntfollower.innerText - 1;
                    }
                });
            break;
            case "0": //팔로우 등록 시 버튼 모양 변경
                fetch(followUrl, {
                    method: 'POST',
                    body: JSON.stringify(param)
                })
                .then((res) => res.json())
                .then((res) => {
                    if (res.result) {
                        btnFollow.dataset.follow = '1';
                        btnFollow.classList.add('btn-outline-secondary');
                        btnFollow.classList.remove('btn-primary');
                        btnFollow.innerText = '팔로우 취소';
                    }
                    //follower + 1
                    spanCntfollower.innerText = ~~spanCntfollower.innerText + 1;
                });
            break;
        }
        });
    }
})();