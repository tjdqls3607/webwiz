const ctxOverall = document.getElementById('overall-chart').getContext('2d');
const overallChart = new Chart(ctxOverall, {
    type: 'line',
    data: {
        labels: ['2016', '2017', '2018', '2019', '2020', '2021', '2022'],
        datasets: [{
            label: '감정 추이',
            data: [10, 15, 20, 25, 30, 35, 40],
            borderColor: 'orange',
            fill: false
        }]
    }
});

const ctxUser = document.getElementById('user-chart').getContext('2d');
const userChart = new Chart(ctxUser, {
    type: 'line',
    data: {
        labels: ['Oct 6', 'Oct 8', 'Oct 10', 'Oct 12', 'Oct 14', 'Oct 16', 'Oct 18'],
        datasets: [{
            label: 'OOO님의 감정',
            data: [1, 2, 1, 3, 2, 1, 2],
            borderColor: 'blue',
            fill: false
        }]
    }
});

const ctxEmotion = document.getElementById('emotion-pie-chart').getContext('2d');
const emotionChart = new Chart(ctxEmotion, {
    type: 'doughnut',
    data: {
        labels: ['화창', '맑음', '비', '흐림', '번개'],
        datasets: [{
            label: '감정 분포',
            data: [30, 40, 10, 15, 5],
            backgroundColor: ['#FFCC4E', '#80B463', '#EF404A', '#27AAE1', '#9E7EB9']
        }]
    }
});

const ctx = document.getElementById('age-gender-chart').getContext('2d');

const data = {
    labels: ['10대', '20대', '30대', '40대', '50대 이상'], // 연령대 레이블
    datasets: [
        {
            label: '여성',
            data: [30, 40, 20, 35, 30],
            backgroundColor: [
                '#FFCC4E',
                '#80B463',
                '#EF404A',
                '#27AAE1',
                '#9E7EB9'
            ], // 원래 색상 사용
        },
        {
            label: '남성',
            data: [20, 25, 35, 30, 20],
            backgroundColor: [
                '#FFCC4E',
                '#80B463',
                '#EF404A',
                '#27AAE1',
                '#9E7EB9'
            ].map(color => lightenColor(color, 15)), // 밝게 처리
        },
        {
            label: '선택안함',
            data: [10, 20, 30, 25, 15], // 데이터 예시
            backgroundColor: [
                '#FFCC4E', // 10대
                '#80B463', // 20대
                '#EF404A', // 30대
                '#27AAE1', // 40대
                '#9E7EB9'  // 50대 이상
            ].map(color => lightenColor(color, 25)), // 밝게 처리
        }
    ]
};

const ageGenderChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true,
                beginAtZero: true,
                title: {
                    display: true,
                }
            }
        }
    }
});

// 색상을 밝게 하는 함수
function lightenColor(color, percent) {
    const num = parseInt(color.slice(1), 16); // 색상값을 16진수로 변환
    const amt = Math.round(2.55 * percent); // 밝게 할 양을 계산
    const R = (num >> 16) + amt; // 빨강
    const G = (num >> 8 & 0x00FF) + amt; // 초록
    const B = (num & 0x0000FF) + amt; // 파랑

    return '#' + (0x1000000 + (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 + (G < 255 ? (G < 1 ? 0 : G) : 255) * 0x100 + (B < 255 ? (B < 1 ? 0 : B) : 255)).toString(16).slice(1);
}

// Song switching logic
const songs = [
    { emotion: '화창', title: 'Love Lee', artist: 'AKMU', img: '../imgsrc/love-lee.png' },
    { emotion: '맑음', title: 'HAPPY', artist: 'DAY6', img: '../imgsrc/happy.png' },
    { emotion: '비', title: 'Rain', artist: 'SEVENTEEN', img: '../imgsrc/rain.png' },
    { emotion: '흐림', title: '나는 아픈 건 딱 질색이니까', artist: '(여자)아이들', img: '../imgsrc/cloudy.png' },
    { emotion: '번개', title: 'Thunder', artist: 'Imagine Dragons', img: '../imgsrc/thunder.png' }
];

let currentSongIndex = 0;

function updateSong() {
    const song = songs[currentSongIndex];
    document.getElementById('emotion-title').textContent = `${song.emotion} 노래 1위`;
    document.querySelector('.music-content img').src = song.img;
    const titleElement = document.querySelector('.music-content p:nth-of-type(1)');
    titleElement.textContent = `${song.title}`;
    if (song.title.length > 13) {
        titleElement.style.fontSize = '13px';
    } else {
        titleElement.style.fontSize = '16px';
    }
    document.querySelector('.music-content p:nth-of-type(2)').textContent = `${song.artist}`;
}

document.getElementById('prev-song').addEventListener('click', () => {
    currentSongIndex = (currentSongIndex === 0) ? songs.length - 1 : currentSongIndex - 1;
    updateSong();
});

document.getElementById('next-song').addEventListener('click', () => {
    currentSongIndex = (currentSongIndex === songs.length - 1) ? 0 : currentSongIndex + 1;
    updateSong();
});

setInterval(() => {
    currentSongIndex = (currentSongIndex + 1) % songs.length;
    updateSong();
}, 5000);

// Initial song setup
updateSong();
