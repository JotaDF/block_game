// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

var game;

function loadGame() {
    $(document).ready(function(){
        $.getJSON("http://etec.etb.com.br/moodle/mod/scorm/game.php?op=load", function(result){
                $.each(result, function(i, dados){
                        game = dados;
                        $("div").empty();
                        $("div").append("id: "+game.id + "<br>");
                        $("div").append("userid: "+game.userid + "<br>");
                        $("div").append("scormid: "+game.scormid + "<br>");
                        $("div").append("courseid: "+game.courseid + "<br>");
                        $("div").append("avatar: "+game.avatar + "<br>");
                        $("div").append("score: "+game.score + "<br>");
                        $("div").append("nivel: "+game.nivel + "<br>");
                        $("div").append("recompensas: "+game.recompensas + "<br>");
                });
        });
    });

}
function addAvatar(id_avatar){
    game.avatar = id_avatar;
    alert("Escolhendo avatar:"+game.avatar);
    $.post("http://etec.etb.com.br/moodle/mod/scorm/game.php", {
        op : "update", id : game.id, userid : game.userid, scormid : game.scormid, courseid : game.courseid, avatar : game.avatar, score : game.score, nivel : game.nivel, recompensas : game.recompensas
    }, function(result){
        if(!result){
            alert("Erro ao escolher avatar!");
        }
    });    
    loadGame();
}

function addScore(valor){
    game.score = parseInt(game.score) + parseInt(valor);
    alert("Pontuando: + "+valor);
    $.post("http://etec.etb.com.br/moodle/mod/scorm/game.php", {
        op : "update", id : game.id, userid : game.userid, scormid : game.scormid, courseid : game.courseid, avatar : game.avatar, score : game.score, nivel : game.nivel, recompensas : game.recompensas
    }, function(result){
        if(!result){
            alert("Erro ao pontuar!");
        }
    });    
    loadGame();
}

function delScore(valor){
    game.score = parseInt(game.score) - parseInt(valor);
    alert("Pontuando: - "+valor);
    $.post("http://etec.etb.com.br/moodle/mod/scorm/game.php", {
        op : "update", id : game.id, userid : game.userid, scormid : game.scormid, courseid : game.courseid, avatar : game.avatar, score : game.score, nivel : game.nivel, recompensas : game.recompensas
    }, function(result){
        if(!result){
            alert("Erro ao pontuar!");
        }
    });    
    loadGame();
}

function defineNivel(nivel){
    game.nivel = nivel;
    alert("Definindo Nivel:"+game.nivel);
    $.post("http://etec.etb.com.br/moodle/mod/scorm/game.php", {
        op : "update", id : game.id, userid : game.userid, scormid : game.scormid, courseid : game.courseid, avatar : game.avatar, score : game.score, nivel : game.nivel, recompensas : game.recompensas
    }, function(result){
        if(!result){
            alert("Erro ao definir nivel!");
        }
    });    
    loadGame();
}