## Handy cli commands to setup projects without nasty ms bloat software

Make new solution
```
dotnet(x64) new sln -n <name>
```

Make new sub thingy
```
dotnet(x64) new <type> -n <name>
```
Type could be `classlib` `console`, etc

Add to your solution
```
dotnet(x64) sln <name>.sln add <name2>/<name2>.csproj
```

Can reference them from within each other
```
# From within the thingy dir
dotnet(x64) add reference ../<name>/<name>.csporj
```

