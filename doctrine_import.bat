@ECHO OFF

call vendor\bin\doctrine-module orm:convert-mapping --namespace=Application\Entity\ --force --from-database annotation ./data
call vendor\bin\doctrine-module orm:generate-entities ./data --generate-annotations=true
