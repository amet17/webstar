google.load("language", "1");
j = jQuery.noConflict();
j(document).ready(function () {
    j("form[name='adminForm']").ready(function () {
        if (j(this).find("input[name='name']").length) {
            admin = j(this).find("input[name='name']");
            j(admin).blur(function () {
                ag_val = j(this).val();
                ag_val = trim(ag_val);
                ag_val = agent_ajax(ag_val);
            });
        } else if (j(this).find(":input[name='title']").length) {
            admin = j(this).find("input[name='title']");
            j(admin).blur(function () {
                ag_val = j(this).val();
                ag_val = trim(ag_val);
                ag_val = agent_ajax(ag_val);
            });
        }
    });
    
    function get_trans(ag_val) {
        en_to_ru = {
            'а': 'a',
            'б': 'b',
            'в': 'v',
            'г': 'g',
            'д': 'd',
            'е': 'e',
            'ё': 'jo',
            'ж': 'zh',
            'з': 'z',
            'и': 'i',
            'й': 'j',
            'к': 'k',
            'л': 'l',
            'м': 'm',
            'н': 'n',
            'о': 'o',
            'п': 'p',
            'р': 'r',
            'с': 's',
            'т': 't',
            'у': 'u',
            'ф': 'f',
            'х': 'h',
            'ц': 'c',
            'ч': 'ch',
            'ш': 'sh',
            'щ': 'sch',
            'ъ': '',
            'ы': 'y',
            'ь': '',
            'э': 'je',
            'ю': 'ju',
            'я': 'ja',
            ' ': '-',
            'і': 'i',
            'ї': 'i'
            '-': ''
        };
        ag_val = ag_val.toLowerCase();
        ag_val = ag_val.split("");
        trans = new String();
        for (i = 0; i < ag_val.length; i++) {
            for (key in en_to_ru) {
                val = en_to_ru[key];
                if (key == ag_val[i]) {
                    trans += val;
                    break
                } else if (key == "ї") {
                    trans += ag_val[i]
                }
            }
        }
        return trans;
    }
    
    function inser_trans(result) {
        pole = j("input[name='alias']");
        allvalue = pole.val();
        if (! (allvalue.length)) {
            j(pole).val(result);
        }
    }
    
    function trim(string) {
        string = string.replace(/'|"|<|>|\!|\||@|#|$|%|^|&|\*|\(\)|-|\|\/|;|\+|№|,|\?|_|:|{|}|\[|\]|(\)|(\())/g, "");
        string = string.replace(/(^\s+)|(\s+$)/g, "");
        return string;
    }
    
      function agent_ajax(text) {
        pole = j("input[name='alias']");
        allvalue = pole.val();
        if (allvalue.length) {
            return false;
        }
          google.language.detect(text, function(result) {
            if (!result.error && result.language) {
              if(source_lang_best_alias.length!=0)   result.language= source_lang_best_alias;
              google.language.translate(text, result.language, "en",
              function(result) {
                if (result.translation) {
                    result = get_trans(result.translation);
                    inser_trans(result)
                }
              });
            }
          });
      }
});