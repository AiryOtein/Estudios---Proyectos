let moves = [];
let totalMoves = 0;
let score = 0;

function illuminate(cellPos, time){
    setTimeout(() => {
        document.querySelector('.cell[pos="' + cellPos + '"]').classList.add('active');
        setTimeout(() => {
            document.querySelector('.cell[pos="' + cellPos + '"]').classList.remove('active');
        }, 300);
    }, time);
}

function setMoves(current){
    moves.push(Math.floor(Math.random() * 4) + 1);
    if (current < totalMoves) {
        setMoves(++current);
    }
}

function startGame(){
    moves = [];
    totalMoves = 2;
    score = 0;
    document.querySelector('#start').style.display = 'none';
    document.querySelector('#message').style.display = 'block';
    sequence();
}

function sequence() {
    moves = [];
    setMoves(1);
    document.querySelector('#message').innerHTML = 'Simón dice';
    for (let i = 0; i < moves.length; i++) {
        illuminate(moves[i], 600 * i);
    }
    setTimeout(() => {
        document.querySelector('#message').innerHTML = 'Repite la secuencia';
    }, 600 * moves.length);
}

function cellClick(e){
    let cellPos = e.target.getAttribute('pos');
    illuminate(cellPos, 0);
    if (moves && moves.length) {
        if (moves[0] == cellPos) {
            moves.shift();
            if (!moves.length) {
                totalMoves++;
                score++;
                setTimeout(() => {
                    sequence();
                }, 1000);
            }
        } else {
            document.querySelector('#message').innerHTML = 'GAME OVER';
            fetch('', {
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:'highscore=' + score
            }).then(()=>{
                let hs = document.getElementById('highscore');
                hs.textContent = Math.max(parseInt(hs.textContent), score);
            });
            setTimeout(() => {
                document.querySelector('#start').style.display = 'block';
                document.querySelector('#message').style.display = 'none';
            }, 1000);
        }
    }
}

document.querySelector('#start').addEventListener('click', startGame);
let cells = Array.from(document.getElementsByClassName('cell'));
cells.forEach(cell => {
    cell.addEventListener('click', cellClick);
});
