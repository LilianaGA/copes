SELECT
	distinct RE."Tipo_Trabajo",
	(SELECT 
		count(E.id)
	FROM "Entregables" AS E 
	WHERE RE.id =  E."idRubroEntregable"
	AND E.created_at > '2015-01-01' 
	AND E."Materia" = 'Informática'  
	AND E."Seccion" = '5-1') AS totales,
	(SELECT 
		count(ER.id)
	FROM "Entregables_Recibidos" AS ER ,"Entregables" AS E
	WHERE RE.id =  E."idRubroEntregable"
	AND ER."idEntregable" = E.id
	AND E.created_at > '2015-01-01' 
	AND E."Materia" = 'Informática'  
	AND E."Seccion" = '5-1'
	AND ER."Cedula_Alumno" = '901230456') AS entregados,
	(SELECT 
		count(E.id)
	FROM "Entregables" AS E
	WHERE RE.id =  E."idRubroEntregable"
	AND NOT EXISTS (Select 	* from "Entregables_Recibidos" as ER Where ER."idEntregable" = E.id and ER."Cedula_Alumno" = '901230456')
	AND E.created_at > '2015-01-01' 
	AND E."Materia" = 'Informática'  
	AND E."Seccion" = '5-1'
	AND E."Estado" = 'T') AS sinPresentar,
	(SELECT 
		count(E.id)
	FROM "Entregables" AS E 
	WHERE RE.id =  E."idRubroEntregable"
	AND E.created_at > '2015-01-01' 
	AND E."Materia" = 'Informática'  
	AND E."Seccion" = '5-1'
	AND E."Estado" = 'F') AS pendientes
FROM "Rubros_Entregables"  AS RE, "Entregables" AS E 
WHERE (SELECT 
		count(E.id)
	FROM "Entregables" AS E 
	WHERE E."idRubroEntregable" = RE.id
	AND E.created_at > '2015-01-01' 
	AND E."Materia" = 'Informática'  
	AND E."Seccion" = '5-1') > 0
GROUP BY RE."Tipo_Trabajo", RE.id, E."idRubroEntregable",E.id
ORDER BY RE."Tipo_Trabajo" ASC

