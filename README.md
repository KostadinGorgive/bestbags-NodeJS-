majorcc
Improving the shop and adding new sections by adding https://majorcc.ru/

DELIVERABLES Improving the shop and adding new sections by adding : BIN CHECKER ( BULK BY 20 BIN). BULK CARDS CHECKER 10 (MAX 10 CARDS). BIN REQUESTS FOR USERS AND THE SELLERS GET THE REQUESTS INTO THEIR PANEL AND ACCEPT THE REQUESTS , THE REQUEST PRICE GO 75% TO THE SELLER . THE SELLER HAVE 48 HOURS TO DELIVER THE CARD TO THE USERS. Make cards.php filter as search dropdown , add price range , bank name , card level , option to search multiple bins . Make Accounts level system . Basic (FREE) = 5 minutes check - checker fee : 0.2$ - binPrice = 0.5$ - No Access to cards checker | Major (50$ / month From userbalance) = All free. Add LTC payments method.
cpanel https://34.93.100.25:2083/ majorcc migliormajor987

================= Test account

https://majorcc.ru/ coder987 123456
DB access

Server : mysql5033.site4now.net/ username : a7c06b_majorcc password : miglior456cc
all are php sql api tasks
cards.php

the filters that i'm talking about we want the as search drop down , so the user can type whatever he wants there and the drop-down shows results so he can access like available countries .... all in the database

Like this: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_js_dropdown_filter

====================================================== About : - BIN CHECKER ( BULK BY 20 BIN). THERE IS THE FRONT END IN BIN.PHP ; https://www.majorcc.shop/bin.php

we want to make it search by bulk , using the api : https://bestisben.xyz/place/apidoc /bin search link : https://bestisben.xyz/place/binchecker1

Api password : Tweeters05 bin to test : 428609
BULK CARDS CHECKER 10 (MAX 10 CARDS). there is no front end for it . you can make it designless until we manage it Using same api as the bin checker ; just link changed to : https://bestisben.xyz/place/ccschecker29 password same ; and this one is for full card and if the result contain PAID text it shows RESULT = VALID , others = INVALID

BIN REQUESTS FOR USERS AND THE SELLERS GET THE REQUESTS INTO THEIR PANEL AND ACCEPT THE REQUESTS , THE REQUEST PRICE GO 75% TO THE SELLER . THE SELLER HAVE 48 HOURS TO DELIVER THE CARD TO THE USERS.

there is seller panel in the shop, we want to add bin requesting page, so user have two inputs , bin + price and it go to all sellers panel in bin requests page , shows all available requests and sellers can accept the deal , when he accepts it, it take balance from user and add just 75% from it to seller balance and you need to add new balance to seller (HOLD BALANCE) , when the seller deliver the card and user receive the card in his card history page , the card gonna be hidden when he click check , if the card VALID = seller get balance (75%)

if checker result is INVALID , the user get refund to his balance 100%

Make Accounts level system . Basic (FREE) = 5 minutes check - checker fee : 0.2$ - binPrice = 0.5$ - No Access to cards checker | Major (50$ / month From userbalance) = All free.
New users ; gonna have basic level ; which gonna have only this features ; check_timeout = 300 second , check_fee = 0.3 , binPrice = 0.5$ , No Access to cards checker . No access to bin request page .

Major (50$ / month From userbalance) = access to all new features (bin request , card checker with limit of (500 checks) the other things checker fee - bin price , all as it now. to upgrade to major level it gonna take 50$ from user balance give access

=========== let me tell you how our btc api works so every user has his unique btc address where he can deposit whatever he wants , and when the system detect transaction on it , when the transaction gets confirmed the amount of transaction in blockchain it be added to user balance i mean any user when he click the deposit page , the api generate unique address for him and add it to database

https://www.majorcc.ru/deposit.php it's something related to api it track the transaction

but you gonna work with different api https://documenter.getpostman.com/view/7907941/S1a32n38?version=latest#intro we can work with this i guess all good and clear except the database credts