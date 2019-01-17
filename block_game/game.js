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

//variaveis globais
var game;
var recompensas=[];
var fases=[];
var url= window.location.origin+"/moodle";

//Carregar o game do usuario
function loadGame() {
    $(document).ready(function(){
        $.getJSON(url+"/blocks/game/game.php?op=load", function(result){
                $.each(result, function(i, dados){
                        game = dados;
                        recompensas=[];
                        if(game.recompensas!=0 || game.recompensas!=''){
                            for(var i = 0; i < game.recompensas.length; i++) {
                                recompensas.push(parseInt(game.recompensas[i]));;
                            }
                        }else{
                            recompensas=new Array(0);
                        }
                        fases=[];
                        if(game.fases!=0 || game.fases!=''){
                            for(var i = 0; i < game.fases.length; i++) {
                                fases.push(parseInt(game.fases[i]));;
                            }
                        }else{
                            fases=new Array(0);
                        }
                });
        });
    });

}
function saveGame(){
    $.post(url+"/blocks/game/game.php", {
        op : "update", id : game.id, userid : game.userid, scormid : game.scormid, courseid : game.courseid, avatar : game.avatar, score : game.score, nivel : game.nivel, fases : fases.toString(), recompensas : recompensas.toString()
    }, function(result){
        if(!result){
            alert("Erro ao atualizar game!");
        }
    });
}
//Atribuir um avatar ao usuario
function addAvatar(id_avatar){
    game.avatar = id_avatar;
    //alert("Escolhendo avatar:"+game.avatar);
    $.post(url+"/blocks/game/game.php", {
        op : "avatar", id : game.id, avatar : game.avatar
    }, function(result){
        if(!result){
            alert("Erro ao escolher avatar!");
        }
    });
    loadGame();
}
//Somar valor ao score do usuario
function addScore(valor){
    game.score = parseInt(game.score) + parseInt(valor);
    //alert("Pontuando: + "+valor);
    $.post(url+"/blocks/game/game.php", {
        op : "score", id : game.id, score : game.score
    }, function(result){
        if(!result){
            alert("Erro ao pontuar!");
        }
    });
    loadGame();
}
//Subtrair valor ao score do usuario
function delScore(valor){
    game.score = parseInt(game.score) - parseInt(valor);
    //alert("Pontuando: - "+valor);
    $.post(url+"/blocks/game/game.php", {
        op : "score", id : game.id, score : game.score
    }, function(result){
        if(!result){
            alert("Erro ao pontuar!");
        }
    });
    loadGame();
}
//Definir nivel do usuario
function defineNivel(nivel){
    game.nivel = nivel;
    //alert("Definindo Nivel:"+game.nivel);
    $.post(url+"/blocks/game/game.php", {
        op : "nivel", id : game.id, nivel : game.nivel
    }, function(result){
        if(!result){
            alert("Erro ao definir nivel!");
        }
    });
    loadGame();
}
//Adcionar uma recompensa ao usuario
function addRecompensa(item){
      recompensas.push(item);
      //alert("Adcionando recompensa: "+item+" reconpensas:"+recompensas.toString());
      $.post(url+"/blocks/game/game.php", {
          op : "recompensas", id : game.id, recompensas : recompensas.toString()
      }, function(result){
          if(!result){
              alert("Erro ao adcionar recompensa!");
          }
      });
      loadGame();
}
//salva vetor de reconpensas no banco
function saveRecompensa(){
      $.post(url+"/blocks/game/game.php", {
          op : "recompensas", id : game.id, recompensas : recompensas.toString()
      }, function(result){
          if(!result){
              alert("Erro ao adcionar recompensa!");
          }
      });
      loadGame();
}
//Remover uma recompensa do usuario
function delRecompensa(item){
    recompensas.remove(item);
    //alert("Removendo recompensa: "+item+" id: "+game.id+" reconpensas:"+recompensas.toString());
    $.post(url+"/blocks/game/game.php", {
        op : "recompensas", id : game.id, recompensas : recompensas.toString()
    }, function(result){
        if(!result){
            alert("Erro ao remover recompensa!");
        }
    });
    loadGame();
}
//Adcionar uma recompensa ao usuario
function addFase(item){
      fases.push(item);
      //alert("Adcionando fase: "+item+" fases:"+fases.toString());
      $.post(url+"/blocks/game/game.php", {
          op : "fases", id : game.id, fases : fases.toString()
      }, function(result){
          if(!result){
              alert("Erro ao adcionar fase!");
          }
      });
      loadGame();
}
//salva vetor de fases no banco
function saveFase(){
      //alert("Adcionando fase: "+item+" fases:"+fases.toString());
      $.post(url+"/blocks/game/game.php", {
          op : "fases", id : game.id, fases : fases.toString()
      }, function(result){
          if(!result){
              alert("Erro ao adcionar fase!");
          }
      });
      loadGame();
}
//Remover uma recompensa do usuario
function delFase(item){
    fases.remove(item);
    //alert("Removendo fase: "+item+" id: "+game.id+" fases:"+fases.toString());
    $.post(url+"/blocks/game/game.php", {
        op : "fases", id : game.id, fases : fases.toString()
    }, function(result){
        if(!result){
            alert("Erro ao remover fase!");
        }
    });
    loadGame();
}
//Adciona metodo para remover item de array
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};