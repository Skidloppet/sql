LIVE = alla filer som används på hemsidan
phpFunc = php funktioner som bör implementeras
finnished = avklarade.

lägg in connect.php i live.
Flyttade runt lite filer och sorterade till 3 mappar, bilderna i en ny mapp innuti live(tänk på rättigheterna för nya mappen på skolans server). 
________________________________________________

http://www.w3schools.com/xml/ajax_intro.asp
________________________________________________

GITHUB..


kommandon för att röra sig runt i cmd/terminal/git terminalen
cd ..
cd mappnamn/
cd mappnamn/mappnamn2/
mkdir mappnamn3
rm -r mappnamn2
cd mappnamn3/


för att starta github i en mapp man vill jobba behöver man säga till programmet github
git init

hämtas ifrån github genom att gå in i organisationer och kopiera länken för clone av respitory "sql"(man måste högerklicka för att klistra in om man kör cmd/terminal)
git clone www.ctrlV./skidloppet/sql

kolla läget på filerna
git status

hämta senaste filerna (innan man jobbar,jobbat färdigt & mergar)
git pull

lägga till en fil och lägga till alla filer (som skapats eller ändrats)
git add filnamn.php
git add -A

för att köa filerna till github och lämna medelande 
git commit -m "specifikt medelande om vad som skapades/ändrades/togs bort."

för att ladda upp filerna till github
git push

Detta sker när man inte gjort en status eller pull innan man började ladda upp filerna eller när någon har laddat upp innan så får man error(*eftersom du inte har de senaste filerna). här måste man "sammankoppla" merga filerna för att få med bådas förändringar i koden.
git merge origin master
git commmit -m "klicka uppknappen för att få tidigare kommando"
git push


(***lite om grenar som det är vanligt att man jobbar på i verkligheten då 
master är troligen den grenen som är aktiv för spelet/hemsidan/servern och för tillfället så skapar man nya grenar som man sedan "patchar" mergar in i huvud grenen 'master', detta kan man göra genom att skapa en ny gren och jobba på den,sedan när man fått nya "funktionen" featuren att fungera så hoppar man till huvudgrenen 'master' och "patchar" in den. vi jobbar inte med grenar och vi sitter istället direkt på huvudgrenen, men här är kommandona.)


kolla efter lokala branches
git branch

kolla efter alla branches från alla i projektet
git branch -a

skapa en ny branch att jobba på
git branch Lasse
git pull origin master

hoppa till en annan gren
git checkout Lasse
-/jobba/- skapa funktion t.ex.

för att kolla vilken gren man är på och byta till master igen
git branch
git checkout master

för att sammanfoga dina filer med huvudgrenen
git merge orgin Lasse


|@@@|
|@@@|
|@@@|




