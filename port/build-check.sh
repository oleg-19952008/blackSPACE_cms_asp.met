#!/bin/bash
# Local build check for the DarkSpace port (Linux/Mono equivalent of MSBuild net48).
# Compiles all ported C# sources as a library against Mono 4.5 reference assemblies
# plus NuGet packages (MySql.Data, Newtonsoft.Json). Run from repo root or anywhere.
set -e
cd "$(dirname "$0")"
REFDIR=/usr/lib/mono/4.5
REFS=""
for a in System System.Core System.Data System.Web System.Web.Extensions System.Xml \
         System.Net.Http System.Transactions System.Configuration System.Drawing \
         System.EnterpriseServices; do
    [ -f "$REFDIR/$a.dll" ] && REFS="$REFS -r:$REFDIR/$a.dll"
done
REFS="$REFS -r:packages/MySql.Data.6.9.12/lib/net45/MySql.Data.dll"
REFS="$REFS -r:packages/Newtonsoft.Json.13.0.1/lib/net45/Newtonsoft.Json.dll"
SRC=$(find App_Code *.aspx.cs api.ashx.cs GameAPI.ashx.cs Global.asax.cs -name '*.cs' | grep -v '\.designer\.')
mcs -target:library -langversion:6 $REFS -out:/tmp/darkspace_build_check.dll $SRC
