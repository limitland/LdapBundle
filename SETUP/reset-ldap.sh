#!/bin/sh

stty -echo
read -p "Enter Manager password: " PASS; echo
stty echo

xist=`grep "^dn:" demouser.limitland.lan.ldif | sed 's/^dn: //g'`
for dn in $xist; do
  ldapdelete -x -D "cn=admin,dc=limitland,dc=lan" -w $PASS "$dn"
done

ldapadd -x -D "cn=admin,dc=limitland,dc=lan" -w $PASS -f demouser.limitland.lan.ldif

