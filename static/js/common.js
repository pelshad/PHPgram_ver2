function encodeQueryString(params) {
    const keys = Object.keys(params);
    return keys.length 
            ? "?" + keys.map(key => 
                        encodeURIComponent(key) + "=" + 
                        encodeURIComponent(params[key])
                    ).join("&")
            : "";
}

function getDateTimeInfo(dt) {
    const nowDt = new Date();
    const targetDt = new Date(dt);

    const nowDtSec = parseInt(nowDt.getTime() * 0.001);
    const targetDtSec = parseInt(targetDt.getTime() * 0.001);

    const diffSec = nowDtSec - targetDtSec;
    if(diffSec < 120) {
        return '1분 전';
    } else if(diffSec < 3600) { //분 단위 (60 * 60)
        return `${parseInt(diffSec / 60)}분 전`;
    } else if(diffSec < 86400) { //시간 단위 (60 * 60 * 24)
        return `${parseInt(diffSec / 3600)}시간 전`;
    } else if(diffSec < 2592000) { //일 단위 (60 * 60 * 24 * 30)
        return `${parseInt(diffSec / 86400)}일 전`;
    }
    return targetDt.toLocaleString();
}

/*(function(){// HTML의 <script> 요소를 생성한다
    const se = document.createElement('script');
    // <script> 요소의 src 속성을 설정한다
    se.src = 'https://ipinfo.io?callback=callback';
    // <body> 요소의 하위 끝에 붙인다
    // 그리고 콜백 함수를 호출한다
    document.body.appendChild(se);
    // 앞서 생성한 <script> 요소를 제거한다
    document.body.removeChild(se);
    
    // 콜백 함수가 호출된다
    function callback(data) {
      alert(data.ip);
    }})();*/
