# zabbix-pfsense-gateway

#Pré requisitos
* Instalar o pacote sudo no pfsense
* Dar permissão pro grupo wheel "NO PASSWORD" System -> Sudo

#PROCEDIMENTO MANUAL 
* Adicionar o usuario Zabbix ao grupo Wheel
  -> pw groupmod wheel -m zabbix
* Colocar o script gateway.php em /scripts/gateway.php no pfsense
* Adicionar o UserParameter
  -> UserParameter=gateway[*],sudo php /scripts/gateway.php $1 $2 $3 $4
* Importar o template Zabbix-Template-PFSense-Gateways.xml

#PROCEDIMENTO AUTOMÁTICO

Diagnostics > command Prompt
executar o comando abaixo
fetch -q -o - https://raw.githubusercontent.com/lndgoncalves/zabbix-pfsense-gateway/master/auto-config.sh | sh


