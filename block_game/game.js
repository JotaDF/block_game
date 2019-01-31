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

//global variables
var game;
var achievements=[];
var phases=[];
var rewards=[];
var url= window.location.origin+"/moodle";

//Load the user game
function loadGame() {
    $(document).ready(function(){
        $.getJSON(url+"/blocks/game/game.php?op=load", function(result){
                $.each(result, function(i, dados){
                        game = dados;
                        rewards=[];
                        if(game.rewards!=0 || game.rewards!=''){
                            for(var i = 0; i < game.rewards.length; i++) {
                                rewards.push(parseInt(game.rewards[i]));;
                            }
                        }else{
                            rewards=new Array(0);
                        }
                        phases=[];
                        if(game.phases!=0 || game.phases!=''){
                            for(var i = 0; i < game.phases.length; i++) {
                                phases.push(parseInt(game.phases[i]));;
                            }
                        }else{
                            phases=new Array(0);
                        }
                        achievements=[];
                        if(game.achievements!=0 || game.achievements!=''){
                            for(var i = 0; i < game.achievements.length; i++) {
                                achievements.push(parseInt(game.achievements[i]));;
                            }
                        }else{
                            achievements=new Array(0);
                        }
                });
        });
    });

}
function saveGame(){
    $.post(url+"/blocks/game/game.php", {
        op : "update", id : game.id, userid : game.userid, courseid : game.courseid, avatar : game.avatar, score : game.score, level : game.level, phases : phases.toString(), rewards : rewards.toString()
    }, function(result){
        if(!result){
            alert("Error updating game!");
        }
    });
}
//Assign an avatar to the user
function addAvatar(id_avatar){
    game.avatar = id_avatar;
    $.post(url+"/blocks/game/game.php", {
        op : "avatar", id : game.id, avatar : game.avatar
    }, function(result){
        if(!result){
            alert("Error setting avatar!");
        }
    });
    loadGame();
}
//Add value to the user's score
function addScore(valor){
    game.score = parseInt(game.score) + parseInt(valor);
    $.post(url+"/blocks/game/game.php", {
        op : "score", id : game.id, score : game.score
    }, function(result){
        if(!result){
            alert("Error while scoring!");
        }
    });
    loadGame();
}
//Subtract value from user score
function delScore(valor){
    game.score = parseInt(game.score) - parseInt(valor);
    $.post(url+"/blocks/game/game.php", {
        op : "score", id : game.id, score : game.score
    }, function(result){
        if(!result){
            alert("Error while scoring!");
        }
    });
    loadGame();
}
//Set user level
function setLevel(level){
    game.level = level;
    $.post(url+"/blocks/game/game.php", {
        op : "level", id : game.id, level : game.level
    }, function(result){
        if(!result){
            alert("Error setting level!");
        }
    });
    loadGame();
}
//Add an achievement to the user
function addAchievements(item){
      achievements.push(item);
      $.post(url+"/blocks/game/game.php", {
          op : "achievements", id : game.id, achievements : achievements.toString()
      }, function(result){
          if(!result){
              alert("Error adding achievement!");
          }
      });
      loadGame();
}
//save vector of achievement
function saveAchievements(){
      $.post(url+"/blocks/game/game.php", {
          op : "achievements", id : game.id, achievements : achievements.toString()
      }, function(result){
          if(!result){
              alert("Error adding achievement!");
          }
      });
      loadGame();
}
//Remove an achievement from the user
function delAchievements(item){
    rewards.remove(item);
    $.post(url+"/blocks/game/game.php", {
        op : "achievements", id : game.id, achievements : achievements.toString()
    }, function(result){
        if(!result){
            alert("Error removing achievement!");
        }
    });
    loadGame();
}

//Add a reward to the user
function addReward(item){
      rewards.push(item);
      $.post(url+"/blocks/game/game.php", {
          op : "rewards", id : game.id, rewards : rewards.toString()
      }, function(result){
          if(!result){
              alert("Error adding reward!");
          }
      });
      loadGame();
}
//save rewards of vector
function saveReward(){
      $.post(url+"/blocks/game/game.php", {
          op : "rewards", id : game.id, rewards : rewards.toString()
      }, function(result){
          if(!result){
              alert("Error adding reward!");
          }
      });
      loadGame();
}
//Remove a reward from the user
function delReward(item){
    rewards.remove(item);
    $.post(url+"/blocks/game/game.php", {
        op : "rewards", id : game.id, rewards : rewards.toString()
    }, function(result){
        if(!result){
            alert("Error removing reward!");
        }
    });
    loadGame();
}
//Add a phase to the user
function addPhase(item){
      phases.push(item);
      $.post(url+"/blocks/game/game.php", {
          op : "phases", id : game.id, phases : phases.toString()
      }, function(result){
          if(!result){
              alert("Error adding phase!");
          }
      });
      loadGame();
}
//save phases of vector
function saveFase(){
      $.post(url+"/blocks/game/game.php", {
          op : "phases", id : game.id, phases : phases.toString()
      }, function(result){
          if(!result){
              alert("Erro ao adcionar fase!");
          }
      });
      loadGame();
}
//Remove a reward from the user
function delFase(item){
    phases.remove(item);
    $.post(url+"/blocks/game/game.php", {
        op : "phases", id : game.id, phases : phases.toString()
    }, function(result){
        if(!result){
            alert("Error removing phase!");
        }
    });
    loadGame();
}
//Set user frame 
function setFrame(frame){
    game.frame = frame;
    $.post(url+"/blocks/game/game.php", {
        op : "frame", id : game.id, frame : game.frame
    }, function(result){
        if(!result){
            alert("Error setting frame!");
        }
    });
    loadGame();
}
//Add method to remove array item
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