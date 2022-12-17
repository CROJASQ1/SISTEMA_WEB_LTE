<!-- 
select tr.idRegional,tr.regional,tmp1.[no],tmp2.si from tblRegional tr,(select tr.idRegional,tmp1.[no] FROM tblRegional tr left JOIN (select te.idRegional,tr.regional,COUNT(te.idRegional) as no from tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf,tblRegional tr 
WHERE td.dato like 'No' AND tr.idRegional=te.idRegional AND tc.idCampo=td.idCampo AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional,tr.regional) tmp1 ON tr.idRegional=tmp1.idRegional) tmp1,(select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,tr.regional,COUNT(te.idRegional) as si from tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf,tblRegional tr 
WHERE td.dato like 'SI' AND tr.idRegional=te.idRegional AND tc.idCampo=td.idCampo AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional,tr.regional) tmp1 ON tr.idRegional=tmp1.idRegional) tmp2 WHERE tmp1.idRegional=tmp2.idRegional AND tr.idRegional=tmp1.idRegional AND tmp1.idRegional=tr.idRegional -->



select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional




consula


SELECT tmp1.idRegional,SUM(tmp1.SI) as total_fallas FROM (select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional
UNION
select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional) tmp1 GROUP BY(tmp1.idRegional);






consulta final


<!-- 

SELECT tr.idRegional,tr.regional,tmp1.total_si,tmp2.total_no FROM tblRegional tr,(SELECT tmp1.idRegional,SUM(tmp1.SI) as total_si 
FROM 
(
select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional
UNION
select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'SI' AND tc.idCampo=td.idCampo AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional
) tmp1 GROUP BY(tmp1.idRegional)) tmp1,(SELECT tmp1.idRegional,SUM(tmp1.SI) as total_no
FROM 
(
select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblPreventivo tp,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tp.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional
UNION
select tr.idRegional,tmp1.[si] FROM tblRegional tr left JOIN (select te.idRegional,COUNT(te.idRegional) as si from tblExtraCanon tex,tblEstaciones te,tblDetalleFormulario td,tblCampo tc,tblFormulario tf
WHERE td.dato like 'NO' AND tc.idCampo=td.idCampo AND tex.idFormulario=tf.idFormulario AND te.idEstacion=tf.idEstacion AND tf.idFormulario=td.idFormulario AND tc.idCampo=9
GROUP BY te.idRegional) tmp1 ON tr.idRegional=tmp1.idRegional
) tmp1 GROUP BY(tmp1.idRegional))tmp2 WHERE tmp1.idRegional=tmp2.idRegional and tr.idRegional=tmp1.idRegional AND tr.idRegional=tmp2.idRegional



 -->