var _puzzleRows = 3;
var _puzzleColumns = 3;
var _canvas;
var _stage; /*kontekst 2D*/
var _img; /*załadowany obrazek*/
var _pieces; /*tablica współ. dla kawałków*/
var _puzzleWidth; /*szerokosc układanki*/
var _puzzleHeight; /*wysokosc układanki*/
var _pieceWidth; /*szerokosc puzzla*/
var _pieceHeight; /*wysokosc puzzla*/
var _currentPiece; /*aktualnie przeciagany*/
var _currentDropPiece; /*puzzle na jaki upuszczamy*/
var _mouse; /*x,y - pozycja wskaznika myszy*/
var _redpiece;
var _allowedPieces;
var _gallery;
var _selectedImage;
var _galleryButton;

function init() {
  _gallery = document.getElementsByClassName("galleryItem");
  //console.log(_gallery);
  _img = new Image();
  _img.addEventListener("load", onImage);
  rand = Math.floor(Math.random() * _gallery.length);
  _img.src = _gallery[rand].src;
  _selectedImage = _img;
}

function toogleGallery() {
  var gal = document.getElementById("gallery");
  if (gal.style.display === "" || gal.style.display === "none") {
    gal.style.display = "block";
  } else {
    gal.style.display = "none";
  }
}

function itemClick(img) {
  _selectedImage.style.borderStyle = "none";
  _selectedImage = img;
  _selectedImage.style.borderStyle = "dotted";
  _selectedImage.style.borderColor = "white";
}

function resetGame() {
  document.onmousedown = null;
  document.onmousemove = null;
  startNewGame();
}

function isNeighbour(piece1, piece2) {
  if (
    (piece1.xPos === piece2.xPos + _pieceWidth &&
      piece1.yPos === piece2.yPos) ||
    (piece1.xPos + _pieceWidth === piece2.xPos &&
      piece1.yPos === piece2.yPos) ||
    (piece1.yPos === piece2.yPos + _pieceHeight &&
      piece1.xPos === piece2.xPos) ||
    (piece1.yPos + _pieceHeight === piece2.yPos && piece1.xPos === piece2.xPos)
  )
    return true;
  else {
    return false;
  }
}

function startNewGame() {
  _img = new Image();
  _img.addEventListener("load", onImage);
  _img.src = _selectedImage.src;
  rows = document.getElementById("rowsCount");
  columns = document.getElementById("columnsCount");
  _puzzleRows = parseInt(columns.value);
  _puzzleColumns = parseInt(rows.value);
  document.onmousedown = null;
  document.onmousemove = null;
  onImage();
}

function onImage() {
  //reformat();
  _pieceWidth = Math.floor(_img.width / _puzzleColumns);
  _pieceHeight = Math.floor(_img.height / _puzzleRows);
  _puzzleWidth = _pieceWidth * _puzzleColumns;
  _puzzleHeight = _pieceHeight * _puzzleRows;
  styleCanvas();
  initPuzzle();
}

function styleCanvas() {
  _canvas = document.getElementById("scene");
  _stage = _canvas.getContext("2d");
  _canvas.width = _puzzleWidth;
  _canvas.height = _puzzleHeight;
  _canvas.style.border = "1px solid black";
}

function initPuzzle() {
  /*inicjalizacja pierwotna i na replay*/
  _pieces = [];
  _allowedPieces = [];
  _mouse = { x: 0, y: 0 };
  _currentPiece = null; /*na wypadek replay*/
  _currentDropPiece = null; /*na wypadek replay*/

  _stage.drawImage(
    _img,
    0,
    0,
    _puzzleWidth,
    _puzzleHeight,
    0,
    0,
    _puzzleWidth,
    _puzzleHeight
  );
  createTitle("Click to Start Puzzle");
  buildPieces();
}

function createTitle(msg) {
  _stage.fillStyle = "#000000";
  _stage.globalAlpha = 0.4;
  _stage.fillRect(100, _puzzleHeight - 40, _puzzleWidth - 200, 40);
  _stage.fillStyle = "#FFFFFF";
  _stage.globalAlpha = 1; /*˙zeby tekst nie był przezr.*/
  _stage.textAlign = "center";
  _stage.textBaseline = "middle";
  _stage.font = "20px Arial";
  _stage.fillText(msg, _puzzleWidth / 2, _puzzleHeight - 20);
}

function buildPieces() {
  var i;
  var piece;
  var xPos = 0;
  var yPos = 0;
  for (i = 0; i < _puzzleRows * _puzzleColumns; i++) {
    piece = {};
    piece.sx = xPos;
    piece.sy = yPos;
    piece.xPos = xPos;
    piece.yPos = yPos;
    _pieces.push(piece);
    xPos += _pieceWidth;
    if (xPos >= _puzzleWidth) {
      xPos = 0;
      yPos += _pieceHeight;
    }
  }
  document.onmousedown = shufflePuzzle;
}

function swapPieces(piece1, piece2) {
  var tmp = { xPos: piece1.xPos, yPos: piece1.yPos };
  piece1.xPos = piece2.xPos;
  piece1.yPos = piece2.yPos;
  piece2.xPos = tmp.xPos;
  piece2.yPos = tmp.yPos;
}

/**
 * Shuffles array in place.
 * @param {Array} a items An array containing the items.
 */
function shuffleArray(a) {
  var j, x, i;
  for (i = a.length - 1; i > 0; i--) {
    j = Math.floor(Math.random() * (i + 1));
    x = a[i];
    a[i] = a[j];
    a[j] = x;
  }
  return a;
}

function swapWithUp(currentPiece) {
  var cxPos = currentPiece.xPos;
  var cyPos = currentPiece.yPos;

  var j;
  for (j = 0; j < _pieces.length; j++) {
    piece = _pieces[j];
    if (piece.yPos + _pieceHeight === cyPos && piece.xPos === cxPos) {
      swapPieces(currentPiece, piece);
      return piece;
    }
  }
  return null;
}

function swapWithLeft(currentPiece) {
  var cxPos = currentPiece.xPos;
  var cyPos = currentPiece.yPos;

  var j;
  for (j = 0; j < _pieces.length; j++) {
    piece = _pieces[j];
    if (piece.xPos + _pieceWidth === cxPos && piece.yPos === cyPos) {
      swapPieces(currentPiece, piece);
      return piece;
    }
  }
  return null;
}

function shufflePieces(k) {
  _redpiece = Math.floor(Math.random() * _pieces.length);

  var i, j;
  for (i = 0; i < k; ++i) {
    for (j = 0; j < _pieces.length; j++) {
      piece = _pieces[j];
      if (isNeighbour(_pieces[_redpiece], piece) && _redpiece != j) {
        _allowedPieces.push(piece);
      }
    }

    r = Math.floor(Math.random() * _allowedPieces.length);
    swapPieces(_pieces[_redpiece], _allowedPieces[r]);
    _allowedPieces.length = 0;
  }

  var check = _pieces[_redpiece];
  while (check.xPos != 0 || check.yPos != 0) {
    r = Math.floor(Math.random() * 2);
    if (r == 0) swapWithLeft(check);
    else if (r == 1) swapWithUp(check);
  }
}

function shufflePuzzle(e) {
  if (e.layerX || e.layerX == 0) {
    _mouse.x = e.layerX - _canvas.offsetLeft;
    _mouse.y = e.layerY - _canvas.offsetTop;
  } else if (e.offsetX || e.offsetX == 0) {
    _mouse.x = e.offsetX - _canvas.offsetLeft;
    _mouse.y = e.offsetY - _canvas.offsetTop;
  }
  _mouse.x = _mouse.x * (_puzzleWidth / _stage.canvas.clientWidth);
  _mouse.y = _mouse.y * (_puzzleHeight / _stage.canvas.clientHeight);

  if (_mouse.x > _puzzleWidth || _mouse.y > _puzzleHeight) return;

  shufflePieces(Math.floor(262144 / Math.log(_puzzleRows * _puzzleColumns)));
  _stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
  var i;
  var piece;
  var xPos = 0;
  var yPos = 0;
  _stage.fillStyle = "rgba(0,0,255,.2)";

  for (i = 0; i < _pieces.length; i++) {
    piece = _pieces[i];
    _stage.drawImage(
      _img,
      piece.sx,
      piece.sy,
      _pieceWidth,
      _pieceHeight,
      piece.xPos,
      piece.yPos,
      _pieceWidth,
      _pieceHeight
    );

    if (isNeighbour(_pieces[_redpiece], piece) && _redpiece != i) {
      //_stage.fillRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
      _allowedPieces.push(piece);
    }

    _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
  }
  _stage.fillStyle = "rgba(255,0,0,.2)";
  _stage.fillRect(
    _pieces[_redpiece].xPos,
    _pieces[_redpiece].yPos,
    _pieceWidth,
    _pieceHeight
  );

  document.onmousedown = onPuzzleClick;
  document.onmousemove = onHoverCheck;
}

function onPuzzleClick(e) {
  if (e.layerX || e.layerX == 0) {
    _mouse.x = e.layerX - _canvas.offsetLeft;
    _mouse.y = e.layerY - _canvas.offsetTop;
  } else if (e.offsetX || e.offsetX == 0) {
    _mouse.x = e.offsetX - _canvas.offsetLeft;
    _mouse.y = e.offsetY - _canvas.offsetTop;
  }
  _mouse.x = _mouse.x * (_puzzleWidth / _stage.canvas.clientWidth);
  _mouse.y = _mouse.y * (_puzzleHeight / _stage.canvas.clientHeight);

  _currentPiece = checkPieceClicked();

  if (_currentPiece != null) {
    var tmp = { xPos: _currentPiece.xPos, yPos: _currentPiece.yPos };
    _currentPiece.xPos = _pieces[_redpiece].xPos;
    _currentPiece.yPos = _pieces[_redpiece].yPos;
    _pieces[_redpiece].xPos = tmp.xPos;
    _pieces[_redpiece].yPos = tmp.yPos;

    _allowedPieces.length = 0;
    resetPuzzleAndCheckWin();
  }
}

function onHoverCheck(e) {
  if (e.layerX || e.layerX == 0) {
    _mouse.x = e.layerX - _canvas.offsetLeft;
    _mouse.y = e.layerY - _canvas.offsetTop;
  } else if (e.offsetX || e.offsetX == 0) {
    _mouse.x = e.offsetX - _canvas.offsetLeft;
    _mouse.y = e.offsetY - _canvas.offsetTop;
  }
  _mouse.x = _mouse.x * (_puzzleWidth / _stage.canvas.clientWidth);
  _mouse.y = _mouse.y * (_puzzleHeight / _stage.canvas.clientHeight);

  _currentPiece = checkPieceClicked();
  if (_currentPiece != null) {
    redrawPuzzle();
    _stage.fillStyle = "rgba(0,0,255,.2)";
    _stage.fillRect(
      _currentPiece.xPos,
      _currentPiece.yPos,
      _pieceWidth,
      _pieceHeight
    );
  } else {
    redrawPuzzle();
  }
}

function checkPieceClicked() {
  var i;
  for (i = 0; i < _allowedPieces.length; ++i) {
    element = _allowedPieces[i];
    if (
      _mouse.x < element.xPos ||
      _mouse.x > element.xPos + _pieceWidth ||
      _mouse.y < element.yPos ||
      _mouse.y > element.yPos + _pieceHeight
    ) {
      //PIECE NOT HIT
    } else {
      return element;
    }
  }

  return null;
}

function redrawPuzzle() {
  _stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
  var i;
  var piece;
  for (i = 0; i < _pieces.length; i++) {
    piece = _pieces[i];
    _stage.drawImage(
      _img,
      piece.sx,
      piece.sy,
      _pieceWidth,
      _pieceHeight,
      piece.xPos,
      piece.yPos,
      _pieceWidth,
      _pieceHeight
    );
    _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
  }
  _stage.fillStyle = "rgba(255,0,0,.2)";
  _stage.fillRect(
    _pieces[_redpiece].xPos,
    _pieces[_redpiece].yPos,
    _pieceWidth,
    _pieceHeight
  );
}

function resetPuzzleAndCheckWin() {
  _stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
  var gameWin = true;
  var i;
  var piece;
  for (i = 0; i < _pieces.length; i++) {
    piece = _pieces[i];
    _stage.drawImage(
      _img,
      piece.sx,
      piece.sy,
      _pieceWidth,
      _pieceHeight,
      piece.xPos,
      piece.yPos,
      _pieceWidth,
      _pieceHeight
    );
    if (isNeighbour(_pieces[_redpiece], piece) && _redpiece != i) {
      //_stage.fillRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
      _allowedPieces.push(piece);
    }
    _stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
    if (piece.xPos != piece.sx || piece.yPos != piece.sy) {
      gameWin = false;
    }
  }
  if (gameWin) {
    setTimeout(gameOver, 500);
  } else {
    _stage.fillStyle = "rgba(255,0,0,.2)";
    _stage.fillRect(
      _pieces[_redpiece].xPos,
      _pieces[_redpiece].yPos,
      _pieceWidth,
      _pieceHeight
    );
  }
}

function gameOver() {
  document.onmousedown = null;
  document.onmousemove = null;
  document.onmouseup = null;
  initPuzzle();
}
